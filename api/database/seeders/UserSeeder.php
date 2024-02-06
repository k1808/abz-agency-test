<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usedPhones = [];

        User::factory()
            ->count(50)
            ->create([
                'email' => fn() => fake()->unique()->safeEmail(),
                'phone' => function () use (&$usedPhones) {
                    $phone = '+380' . random_int(100000000, 999999999);
                    while (in_array($phone, $usedPhones)) {
                        $phone = '+380' . random_int(100000000, 999999999);
                    }
                    $usedPhones[] = $phone;
                    return $phone;
                },
                'position_id' => rand(1, 4),
            ]);

    }
}
