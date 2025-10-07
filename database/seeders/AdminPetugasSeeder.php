<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Petugas;

class AdminPetugasSeeder extends Seeder
{
    public function run(): void
    {
        $accounts = [
            // Core admin account
            ['email' => 'admin@elunora.com',   'username' => 'admin',   'password' => 'password123'],
            // Requested new admin account
            ['email' => 'minora@elunora.com',  'username' => 'minora',  'password' => 'minora'],
            // Requested staff account
            ['email' => 'staff@elunora.com',   'username' => 'staff',   'password' => 'staff'],
        ];

        foreach ($accounts as $acc) {
            Petugas::updateOrCreate(
                ['email' => $acc['email']],
                [
                    'username' => $acc['username'],
                    // setPasswordAttribute mutator will hash automatically
                    'password' => $acc['password'] ?? 'password123',
                ]
            );
        }
    }
}
