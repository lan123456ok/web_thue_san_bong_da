<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pitch>
 */
class PitchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> 'Sân'. ' ' . fake()->company(),
            'address'=> fake()->streetAddress(),
            'address2'=> fake()->buildingNumber(),
            'district'=> fake()->city,
            'city'=> fake()->city(),
            'country'=> 'Vietnam',
            'zipcode'=> fake()->postcode(),
        ];
    }
}
