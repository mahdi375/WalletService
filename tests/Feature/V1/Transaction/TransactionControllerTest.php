<?php

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Testing\Fluent\AssertableJson;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('can make a transaction', function () {
    $wallet = Wallet::factory()->create();
    $amount = fake()->numberBetween(-100, 100);

    $payload = [
        'user_id' => $wallet->user_id,
        'amount' => $amount
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
})->only();
