<?php

namespace Database\Factories;

use App\Models\Pitch;
use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SubPitch>
 */
class SubPitchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => fake()->randomElement($array = array('Sân 1', 'Sân 2', 'Sân 3', 'Sân 4')),
            'image' => fake()->imageUrl(),
            'type_id' => Type::query()->inRandomOrder()->value('id'),
            'price_per_hour' => fake()->randomFloat($nbMaxDecimals = 3, $min = 100, $max = 350),
            'number_rentered' => fake()->randomDigitNotNull(),
            'pitch_id' => Pitch::query()->inRandomOrder()->value('id'),
        ];
    }
}
