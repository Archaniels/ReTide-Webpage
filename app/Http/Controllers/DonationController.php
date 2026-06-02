<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\DonationUpdate;
use App\Models\Payment;
use Midtrans\Config;
use Midtrans\Snap;

class DonationController extends Controller
{
    public function index()
    {
        // 1. Ambil donasi dari user yang login
        $donations = Donation::where('user_id', auth()->id())->latest()->get();

        // 2. Total donasi keseluruhan
        $totalDonations = Donation::sum('amount');

        return view('donation', compact('donations', 'totalDonations'));
    }

    public function updates(Donation $donation)
    {
        $updates = DonationUpdate::where('donation_id', $donation->id)->latest()->get();
        return response()->json($updates);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'  => 'required|integer|min:1000',
            'email'   => 'nullable|email',
            'name'    => 'nullable|string|max:255',
            'message' => 'nullable|string|max:500',
        ]);

        $donation = Donation::create([
            'name'   => $request->name ?: auth()->user()->name,
            'email'  => $request->email ?: auth()->user()->email,
            'amount' => $request->amount,
            'message' => $request->message,
            'user_id' => auth()->id(),
        ]);

        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $orderId = 'DON-' . time() . '-' . auth()->id();

        // Create Payment record
        Payment::create([
            'order_id' => $orderId,
            'payment_type' => 'donation',
            'status' => 'pending',
            'gross_amount' => $request->amount,
            'user_id' => auth()->id(),
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $request->amount,
            ],
            'customer_details' => [
                'first_name' => $donation->name,
                'email' => $donation->email,
            ],
            'item_details' => [
                [
                    'id' => 'donation-' . $donation->id,
                    'price' => (int) $request->amount,
                    'quantity' => 1,
                    'name' => 'Donation for ReTide',
                ]
            ],
        ];

        try {
            $redirectUrl = Snap::createTransaction($params)->redirect_url;
            return redirect()->away($redirectUrl);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create donation payment: ' . $e->getMessage());
        }
    }

    public function success()
    {
        return view('donation_success');
    }

    public function adminIndex()
    {
        $donations = Donation::with('user')->latest()->get();
        return view('admin.donations.index', compact('donations'));
    }

    public function adminDestroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Donasi berhasil dihapus');
    }
}
