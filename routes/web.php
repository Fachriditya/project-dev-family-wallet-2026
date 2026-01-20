<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\User\DashboardUserController;


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


Route::middleware(['auth', 'isAdmin'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [DashboardAdminController::class, 'index'])->name('dashboard');
    
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserManagementController::class, 'create'])->name('users.create');
    Route::post('/users', [UserManagementController::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [UserManagementController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserManagementController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{id}/reset-password', [UserManagementController::class, 'resetPassword'])->name('users.reset-password');
    
    Route::get('/transactions', [TransactionAdminController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/create', [TransactionAdminController::class, 'create'])->name('transactions.create');
    Route::post('/transactions', [TransactionAdminController::class, 'store'])->name('transactions.store');
    Route::delete('/transactions/{id}', [TransactionAdminController::class, 'destroy'])->name('transactions.destroy');
    

    Route::get('/leaderboard', [LeaderboardAdminController::class, 'index'])->name('leaderboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});


Route::middleware(['auth', 'isUser'])->prefix('user')->name('user.')->group(function () {
    
    Route::get('/dashboard', [DashboardUserController::class, 'index'])->name('dashboard');
    
    Route::get('/transactions', [TransactionUserController::class, 'index'])->name('transactions.index');
    Route::post('/transactions/nabung', [TransactionUserController::class, 'nabung'])->name('transactions.nabung');
    Route::post('/transactions/tarik', [TransactionUserController::class, 'tarik'])->name('transactions.tarik');
    
    Route::get('/leaderboard', [LeaderboardUserController::class, 'index'])->name('leaderboard');
    

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
});

require __DIR__.'/auth.php';
