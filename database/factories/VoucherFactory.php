<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->bothify('VOUCHER-####'),
            'discount_type' => $this->faker->randomElement(['percent', 'amount']),
            'discount_value' => $this->faker->randomFloat(2, 5, 100),
            'discount_max' => $this->faker->numberBetween(50, 500),
            'quantity' => $this->faker->numberBetween(10, 100),
            'user_count' => $this->faker->numberBetween(1, 50),
            'day_start' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'day_end' => $this->faker->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
