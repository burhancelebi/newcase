<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $file = file_get_contents(public_path('json/customers.json'));
        $users = json_decode($file);

        foreach ($users as $user)
        {
            User::query()->create([
                'email' => $faker->email,
                'name' => $user->name,
                'since' => $user->since,
                'revenue' => $user->revenue,
                'password' => Hash::make(1234),
            ]);
        }
    }
}
