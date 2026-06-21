<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@retide.com'],
            [
                'name' => 'Admin ReTide',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
    }
}
