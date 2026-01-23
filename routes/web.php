<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\UsersManagementController;  // ✅ UPDATED
use App\Http\Controllers\Admin\TransactionsManagementController;  // ✅ UPDATED
use App\Http\Controllers\User\DashboardUserController;
use App\Http\Controllers\User\TransactionUserController;

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->role === 1) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }
    return redirect()->route('login');
});

// ============================================
// ADMIN ROUTES (Role = 1)
// ============================================
Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [UsersManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UsersManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UsersManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UsersManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UsersManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UsersManagementController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/reset-password', [UsersManagementController::class, 'resetPassword'])->name('users.reset-password');
    
    // Transaction Management
    Route::get('/transactions', [TransactionsManagementController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionsManagementController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionsManagementController::class, 'store'])->name('transactions.store');
    
    // Profile Admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// USER ROUTES (Role = 2)
// ============================================
Route::middleware(['auth', 'isUser'])->prefix('user')->name('user.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardUserController::class, 'index'])->name('dashboard');
    
    // Transactions
    Route::get('/transactions', [TransactionUserController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/nabung', [TransactionUserController::class, 'nabung'])->name('transactions.nabung');
    Route::post('/transactions/tarik', [TransactionUserController::class, 'tarik'])->name('transactions.tarik');
    
    // Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// AUTH ROUTES
// ============================================
require __DIR__.'/auth.php';