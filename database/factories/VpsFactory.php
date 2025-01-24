<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vps>
 */
class VpsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Vps::class;

    public function definition(): array
    {
        return [
            'customer_id' => \App\Models\Customers::factory(), // Correct column
            'cpu' => $this->faker->numberBetween(1, 8),
            'ram' => $this->faker->numberBetween(1, 32),
            'storage' => $this->faker->numberBetween(10, 500),
            'status' => 'active',
        ];
    }
}
