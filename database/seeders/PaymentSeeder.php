<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        Payment::create([
            'order_id' => 'TRX-'.time(),
            'transaction_id' => 'midtrans-test-id-123',
            'payment_type' => 'donation',
            'status' => 'settlement',
            'gross_amount' => 50000,
            'user_id' => $user ? $user->id : null,
            'payload' => [
                'transaction_time' => now()->toDateTimeString(),
                'transaction_status' => 'settlement',
                'status_message' => 'midtrans payment response',
                'payment_type' => 'credit_card',
            ],
        ]);
    }
}
