-- ============================================
-- DB Family Wallet 2026 
-- ============================================

USE family_wallet_2026;

-- ============================================
-- TABLES
-- ============================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    photo VARCHAR(255),
    role TINYINT NOT NULL DEFAULT 2 COMMENT '1=admin, 2=user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL
);

CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    jenis_transaksi CHAR(1) NOT NULL COMMENT 'M=Masuk, K=Keluar',
    jumlah DECIMAL(15,2) NOT NULL,
    note TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    CONSTRAINT fk_transactions_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
);

CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id INT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL
);

-- ============================================
-- VIEWS
-- ============================================

CREATE OR REPLACE VIEW v_total_saldo AS
SELECT
    COALESCE(SUM(CASE WHEN jenis_transaksi = 'M' THEN jumlah ELSE 0 END), 0) AS total_masuk,
    COALESCE(SUM(CASE WHEN jenis_transaksi = 'K' THEN jumlah ELSE 0 END), 0) AS total_keluar,
    COALESCE(SUM(CASE WHEN jenis_transaksi = 'M' THEN jumlah ELSE -jumlah END), 0) AS saldo,
    COUNT(CASE WHEN jenis_transaksi = 'M' THEN 1 END) AS jumlah_transaksi_masuk,
    COUNT(CASE WHEN jenis_transaksi = 'K' THEN 1 END) AS jumlah_transaksi_keluar,
    COUNT(*) AS total_transaksi
FROM transactions
WHERE deleted_at IS NULL;

CREATE OR REPLACE VIEW v_kontribusi_user AS
SELECT
    u.id,
    u.nama,
    u.username,
    u.photo,
    COALESCE(SUM(CASE WHEN t.jenis_transaksi = 'M' THEN t.jumlah ELSE 0 END), 0) AS total_masuk,
    COALESCE(SUM(CASE WHEN t.jenis_transaksi = 'K' THEN t.jumlah ELSE 0 END), 0) AS total_keluar,
    COALESCE(SUM(CASE WHEN t.jenis_transaksi = 'M' THEN t.jumlah ELSE -t.jumlah END), 0) AS saldo,
    COUNT(CASE WHEN t.jenis_transaksi = 'M' THEN 1 END) AS jumlah_nabung,
    COUNT(CASE WHEN t.jenis_transaksi = 'K' THEN 1 END) AS jumlah_tarik,
    COUNT(t.id) AS total_transaksi,
    RANK() OVER (ORDER BY COALESCE(SUM(CASE WHEN t.jenis_transaksi = 'M' THEN t.jumlah ELSE -t.jumlah END), 0) DESC) AS ranking
FROM users u
LEFT JOIN transactions t ON u.id = t.user_id AND t.deleted_at IS NULL
WHERE u.deleted_at IS NULL AND u.role = 2
GROUP BY u.id, u.nama, u.username, u.photo;

CREATE OR REPLACE VIEW v_leaderboard AS
SELECT 
    id,
    nama,
    username,
    photo,
    total_masuk,
    total_keluar,
    saldo,
    jumlah_nabung,
    jumlah_tarik,
    total_transaksi,
    ranking,
    ROUND((saldo / NULLIF((SELECT saldo FROM v_total_saldo), 0)) * 100, 2) AS persentase_kontribusi
FROM v_kontribusi_user
ORDER BY ranking ASC;

-- ============================================
-- STORED PROCEDURES
-- ============================================

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_tambah_transaksi$$
CREATE PROCEDURE sp_tambah_transaksi(
    IN p_user_id INT,
    IN p_jenis CHAR(1),
    IN p_jumlah DECIMAL(15,2),
    IN p_note TEXT
)
SQL SECURITY INVOKER
BEGIN
    DECLARE user_ada INT;
    DECLARE saldo_user DECIMAL(15,2);
    
    SELECT COUNT(*) INTO user_ada 
    FROM users 
    WHERE id = p_user_id AND deleted_at IS NULL;
    
    IF user_ada = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'User tidak ditemukan';
    END IF;
    
    IF p_jumlah <= 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jumlah harus lebih dari 0';
    END IF;
    
    IF p_jenis NOT IN ('M', 'K') THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Jenis transaksi harus M atau K';
    END IF;
    
    IF p_jenis = 'K' THEN
        SELECT COALESCE(SUM(CASE WHEN jenis_transaksi = 'M' THEN jumlah ELSE -jumlah END), 0) 
        INTO saldo_user
        FROM transactions
        WHERE user_id = p_user_id AND deleted_at IS NULL;
        
        IF saldo_user < p_jumlah THEN
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Saldo tidak cukup';
        END IF;
    END IF;
    
    INSERT INTO transactions (user_id, jenis_transaksi, jumlah, note)
    VALUES (p_user_id, p_jenis, p_jumlah, p_note);
    
    SELECT 
        LAST_INSERT_ID() AS id_transaksi,
        COALESCE(SUM(CASE WHEN jenis_transaksi = 'M' THEN jumlah ELSE -jumlah END), 0) AS saldo_baru
    FROM transactions
    WHERE user_id = p_user_id AND deleted_at IS NULL;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_tabung$$
CREATE PROCEDURE sp_tabung(
    IN p_user_id INT,
    IN p_jumlah DECIMAL(15,2),
    IN p_note TEXT
)
SQL SECURITY INVOKER
BEGIN
    CALL sp_tambah_transaksi(p_user_id, 'M', p_jumlah, p_note);
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_tarik$$
CREATE PROCEDURE sp_tarik(
    IN p_user_id INT,
    IN p_jumlah DECIMAL(15,2),
    IN p_note TEXT
)
SQL SECURITY INVOKER
BEGIN
    CALL sp_tambah_transaksi(p_user_id, 'K', p_jumlah, p_note);
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_summary_user$$
CREATE PROCEDURE sp_summary_user(IN p_user_id INT)
SQL SECURITY INVOKER
BEGIN
    SELECT 
        u.id,
        u.nama,
        u.username,
        u.photo,
        COALESCE(SUM(CASE WHEN t.jenis_transaksi = 'M' THEN t.jumlah ELSE 0 END), 0) AS total_masuk,
        COALESCE(SUM(CASE WHEN t.jenis_transaksi = 'K' THEN t.jumlah ELSE 0 END), 0) AS total_keluar,
        COALESCE(SUM(CASE WHEN t.jenis_transaksi = 'M' THEN t.jumlah ELSE -t.jumlah END), 0) AS saldo,
        COUNT(CASE WHEN t.jenis_transaksi = 'M' THEN 1 END) AS jumlah_tabung,
        COUNT(CASE WHEN t.jenis_transaksi = 'K' THEN 1 END) AS jumlah_tarik,
        COUNT(t.id) AS total_transaksi,
        (SELECT ranking FROM v_kontribusi_user WHERE id = p_user_id) AS ranking
    FROM users u
    LEFT JOIN transactions t ON u.id = t.user_id AND t.deleted_at IS NULL
    WHERE u.id = p_user_id AND u.deleted_at IS NULL
    GROUP BY u.id, u.nama, u.username, u.photo;
END$$
DELIMITER ;

DELIMITER $$
DROP PROCEDURE IF EXISTS sp_reset_password$$
CREATE PROCEDURE sp_reset_password(IN p_user_id INT)
SQL SECURITY INVOKER
BEGIN
    DECLARE user_ada INT;
    DECLARE user_role TINYINT;
    
    SELECT COUNT(*), MAX(role) INTO user_ada, user_role
    FROM users 
    WHERE id = p_user_id AND deleted_at IS NULL;
    
    IF user_ada = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'User tidak ditemukan';
    END IF;
    
    IF user_role = 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Tidak bisa reset password admin';
    END IF;
    
    UPDATE users 
    SET password = '$2y$10$Dtf/Q8cjXmJvewWGTye8bOehY51JJTKBHjexDHmlINFukmdT8x3Hm',
        updated_at = NOW()
    WHERE id = p_user_id;
    
    SELECT 'Password direset ke 123456' AS pesan;
END$$
DELIMITER ;

-- ============================================
-- DATA
-- ============================================

INSERT INTO users (nama, username, password, role) VALUES
('Admin', 'Admin', '$2y$10$Dtf/Q8cjXmJvewWGTye8bOehY51JJTKBHjexDHmlINFukmdT8x3Hm', 1);

