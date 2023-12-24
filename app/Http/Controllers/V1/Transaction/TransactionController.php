<?php

namespace App\Http\Controllers\V1\Transaction;

use App\Http\Controllers\V1\BaseController;
use App\Http\Requests\StoreTransactionRequest;
use App\Services\WalletService;
use Illuminate\Http\JsonResponse;

class TransactionController extends BaseController
{
    public function __construct(private WalletService $walletService)
    {
    }

    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $transaction = $this->walletService->makeTransaction($request->user_id, $request->amount);

        $this->walletService->addMoneyToUserWallet($request->user_id, $request->amount);

        return $this->response([
            'reference_id' => $transaction->id,
        ]);
    }
}
