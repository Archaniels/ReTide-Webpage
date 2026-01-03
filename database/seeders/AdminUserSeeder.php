<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@retide.com'],
            [
                'name' => 'Admin ReTide',
                'password' => bcrypt('password'),
                'role' => 'admin',
            ]
        );
    }
}
