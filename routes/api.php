<?php

use App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Начисление средств
    Route::post('deposit', [V1\TransactionController::class, 'deposit'])->name('user.deposit');

    // Списание средств
    Route::post('withdraw', [V1\TransactionController::class, 'withdraw'])->name('user.withdraw');

    // Перевод между пользователями
    Route::post('transfer', [V1\TransactionController::class, 'transfer'])->name('user.transfer');

    // Банас пользователя
    Route::get('balance/{user_id}', [V1\BalanceController::class, 'balance'])->name('user.balance');
});
