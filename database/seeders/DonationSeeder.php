<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Donation;
use App\Models\User;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first admin user
        $admin = User::where('role', 'admin')->first();
        $user = User::where('role', 'user')->first();

        // Create test donations
        Donation::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'amount' => 500000,
            'message' => 'Semoga donasi ini membantu.',
            'user_id' => $user?->id ?? 1,
        ]);

        Donation::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@example.com',
            'amount' => 1000000,
            'message' => 'Berbagi untuk sesama.',
            'user_id' => $user?->id ?? 1,
        ]);

        Donation::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad@example.com',
            'amount' => 250000,
            'message' => 'Mari kita jaga lingkungan bersama.',
            'user_id' => $user?->id ?? 1,
        ]);
    }
}
