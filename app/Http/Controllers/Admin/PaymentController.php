<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index()
    {
        $payments = Payment::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Test the Midtrans Payment Gateway by creating a dummy transaction and redirecting.
     */
    public function test()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $orderId = 'TEST-' . time() . '-' . rand(1000, 9999);
        $amount = 10000;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $amount,
            ],
            'customer_details' => [
                'first_name' => 'Admin',
                'last_name' => 'Tester',
                'email' => auth()->user()->email,
            ],
            'item_details' => [
                [
                    'id' => 'test-item-1',
                    'price' => $amount,
                    'quantity' => 1,
                    'name' => 'Test Donation/Payment',
                ]
            ],
        ];

        try {
            $redirectUrl = Snap::createTransaction($params)->redirect_url;
            return redirect()->away($redirectUrl);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create test transaction: ' . $e->getMessage());
        }
    }
}
