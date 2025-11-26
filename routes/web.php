<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\FinancialInstitutionController;
use App\Http\Controllers\FinancialBranchController;
use App\Http\Controllers\InputSaldoController;


Route::get('/', function () {
    return redirect()->route('login');
});

// Protected routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // User Routes
    Route::resource('/users', UserController::class);

    // Employee Routes
    Route::resource('/employees', EmployeeController::class);

    // Unit Routes
    Route::resource('/units', UnitController::class);

    // Position Routes
    Route::resource('/positions', PositionController::class);

    // Bank Account Routes
    Route::resource('/banks', BankController::class);

    // Financial Institution Routes
    Route::resource('/financial-institutions', FinancialInstitutionController::class);

    // Financial Branch Routes
    Route::get('/financial-branches/next-code', [FinancialBranchController::class, 'getNextCode'])->name('financial-branches.next-code');
    Route::resource('/financial-branches', FinancialBranchController::class);

    // Input Saldo Routes
    Route::get('/input-saldo/bank-accounts', [InputSaldoController::class, 'getBankAccountsByInstitution'])->name('input_saldo.bank_accounts');
    Route::get('/input-saldo/last-balance', [InputSaldoController::class, 'getLastBalance'])->name('input_saldo.last_balance');
    Route::resource('/input-saldo', InputSaldoController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
