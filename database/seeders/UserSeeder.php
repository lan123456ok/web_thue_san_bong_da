<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\Pitch;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = [];
        $faker = \Faker\Factory::create('vi_VN');
        $pitch = Pitch::query()->pluck('id')->toArray();
        // pluck vua select vua bien thanh mang dc

        for($i = 1; $i <= 50000; $i++){
            $role = fake()->randomElement(UserRoleEnum::getValues());
            $arr =[
            'name'=> $faker->firstName() . ' ' . fake()->lastName(),
            'avatar'=> $faker->imageUrl,
            'email'=> $faker->email,
            'password'=> $faker->password,
            'phone'=> $faker->phoneNumber,
            'gender'=> $faker->boolean,
            'bio'=> $faker->boolean ? $faker->word() : null,
            'role'=> $role,
            'pitch_id'=> $role === 2 ? $pitch[array_rand($pitch)] : null,
        ];
        if($i % 1000 === 0){
            User::insert($arr);
            $arr = [];
        }

        }

    }
}
