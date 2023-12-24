<?php

namespace App\Http\Controllers\V1\Wallet;

use App\Http\Controllers\V1\BaseController;
use App\Models\Wallet;
use Illuminate\Http\JsonResponse;

class WalletController extends BaseController
{
    public function getBalance(int $userId): JsonResponse
    {
        $wallet = Wallet::where('user_id', $userId)->firstOrFail();

        return $this->response([
            'balance' => $wallet->balance,
        ]);
    }
}
