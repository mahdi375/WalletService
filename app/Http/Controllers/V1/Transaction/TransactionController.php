<?php

namespace App\Http\Controllers\V1\Transaction;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;

class TransactionController extends BaseController
{
    public function store(StoreTransactionRequest $request): JsonResponse
    {
        // transaction service
        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
        ]);

        // wallet service (used inside transaction service)
        $wallet = Wallet::firstOrCreate(
            ['user_id' => $request->user_id],
            ['balance' => 0]
        );
        $wallet->balance += $request->amount;
        $wallet->save();

        return $this->response([
            'reference_id' => $transaction->id,
        ]);
    }
}
