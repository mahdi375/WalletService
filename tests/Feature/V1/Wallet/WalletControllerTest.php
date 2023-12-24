<?php

use App\Models\Wallet;

use function Pest\Laravel\getJson;

it('can get user wallet balance', function () {
    $wallet = Wallet::factory()->create();

    getJson(route('api.v1.wallet.get-balance', $wallet->user_id))
        ->assertSuccessful()
        ->assertJson([
            'balance' => $wallet->balance,
        ]);
});

it('returns 404 if user wallet does not exist', function () {

    getJson(route('api.v1.wallet.get-balance', fake()->randomNumber()))
        ->assertNotFound();
});
