<?php

namespace Database\Factories;

use App\Models\MerchantProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MerchantProfile>
 */
class MerchantProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->merchant(),
            'company_name' => fake()->company(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'food_type' => fake()->randomElement(['Nasi Kotak', 'Makanan Sehat', 'Prasmanan', 'Kue & Snack']),
            'description' => fake()->sentence(),
        ];
    }
}
