<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class WalletService
{
    public function totalSaldo()
    {
        return DB::selectOne('SELECT * FROM v_total_saldo');
    }

    public function leaderboard()
    {
        return DB::select('SELECT * FROM v_leaderboard');
    }

    public function tabung(int $userId, float $jumlah, ?string $note = null)
    {
        return DB::select(
            'CALL sp_tabung(?, ?, ?)',
            [$userId, $jumlah, $note]
        );
    }

    public function tarik(int $userId, float $jumlah, ?string $note = null)
    {
        return DB::select(
            'CALL sp_tarik(?, ?, ?)',
            [$userId, $jumlah, $note]
        );
    }

    public function summaryUser(int $userId)
    {
        return DB::selectOne(
            'CALL sp_summary_user(?)',
            [$userId]
        );
    }
}
