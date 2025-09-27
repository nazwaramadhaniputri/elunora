<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuestUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Seraphine', 'email' => 'seraphine@gmail.com', 'password' => 'seraphine'],
            ['name' => 'Elion',     'email' => 'elion@gmail.com',     'password' => 'elion'],
            ['name' => 'Mika',      'email' => 'mika@gmail.com',      'password' => 'mika'],
            ['name' => 'Arion',     'email' => 'arion@gmail.com',     'password' => 'arion'],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    // Provide plain password; 'hashed' cast on User model will hash it properly
                    'password' => $u['password'],
                ]
            );
        }
    }
}
