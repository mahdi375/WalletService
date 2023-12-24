<?php

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('can make a transaction', function () {
    $wallet = Wallet::factory()->create();
    $amount = fake()->numberBetween(-100, 100);

    $payload = [
        'user_id' => $wallet->user_id,
        'amount' => $amount,
    ];

    assertDatabaseCount(Transaction::class, 0);

    postJson(route('api.v1.transaction.store'), $payload)
        ->assertSuccessful()
        ->assertJson(fn (AssertableJson $json) => $json
            ->whereType('reference_id', 'integer')
        );

    assertDatabaseHas(Transaction::class, [
        'user_id' => $wallet->user_id,
        'amount' => $amount,
    ]);
});

it('adds ammount to wallet balance', function () {
    $wallet = Wallet::factory()->create();
    $amount = fake()->numberBetween(-100, 100);

    $payload = [
        'user_id' => $wallet->user_id,
        'amount' => $amount,
    ];

    postJson(route('api.v1.transaction.store'), $payload)
        ->assertSuccessful();

    assertDatabaseHas(Wallet::class, [
        'user_id' => $wallet->user_id,
        'balance' => $wallet->balance + $amount,
    ]);
});

it('will create a wallet if it does not exist', function () {
    $amount = fake()->numberBetween(-100, 100);
    $userId = fake()->numberBetween(1, 100);

    $payload = [
        'user_id' => $userId,
        'amount' => $amount,
    ];

    assertDatabaseEmpty(Wallet::class);

    postJson(route('api.v1.transaction.store'), $payload)
        ->assertSuccessful();

    assertDatabaseCount(Wallet::class, 1);
    assertDatabaseHas(Wallet::class, [
        'user_id' => $userId,
        'balance' => $amount,
    ]);
});
