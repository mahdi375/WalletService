<?php

use App\Http\Controllers\V1\Transaction\TransactionController;
use App\Http\Controllers\V1\Wallet\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('ping', fn () => ['ping' => 'pong'])->name('health');

Route::prefix('transactions')->name('transaction.')->group(function () {
    Route::post('/', [TransactionController::class, 'store'])->name('store');
});

Route::prefix('wallets')->name('wallet.')->group(function () {
    Route::get('{userId}/balance', [WalletController::class, 'getBalance'])->name('get-balance');
});
