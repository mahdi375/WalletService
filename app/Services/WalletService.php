<?php

namespace App\Services;

use App\Models\Transaction;
use App\Models\Wallet;

class WalletService
{
    public function makeTransaction(int $userId, int $amount): Transaction
    {
        return Transaction::create([
            'user_id' => $userId,
            'amount' => $amount,
        ]);
    }

    public function addMoneyToUserWallet(int $userId, int $amount): void
    {
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $userId],
            ['balance' => 0]
        );

        $wallet->balance += $amount;
        $wallet->save();
    }
}
