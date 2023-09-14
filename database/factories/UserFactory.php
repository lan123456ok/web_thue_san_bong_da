<?php

namespace Database\Factories;

use App\Enums\UserRoleEnum;
use App\Models\Pitch;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = fake()->randomElement(UserRoleEnum::getValues());

        return [
            'name'=> fake()->firstName() . ' ' . fake()->lastName(),
            'avatar'=> fake()->imageUrl,
            'email'=> fake()->email,
            'password'=> fake()->password,
            'phone'=> fake()->phoneNumber,
            'gender'=> fake()->boolean,
            'bio'=> fake()->boolean ? fake()->word() : null,
            'role'=> $role,
            'pitch_id'=> $role === 2 ? Pitch::query()->inRandomOrder()->value('id') : null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
//    public function unverified(): static
//    {
//        return $this->state(fn (array $attributes) => [
//            'email_verified_at' => null,
//        ]);
//    }
}
