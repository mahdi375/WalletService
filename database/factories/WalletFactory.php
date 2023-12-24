<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Wallet>
 */
class WalletFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(),
            'balance' => fake()->numberBetween(-100, 100),
        ];
    }

    public function balance(int $balance): self
    {
        return $this->state(['balance' => $balance]);
    }

    public function empty(): self
    {
        return $this->balance(0);
    }
}
