<?php

namespace Database\Factories;

use App\Models\Menu;
use App\Models\MerchantProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Menu>
 */
class MenuFactory extends Factory
{
    public function definition(): array
    {
        return [
            'merchant_profile_id' => MerchantProfile::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 10000, 100000),
            'is_available' => true,
        ];
    }
}
