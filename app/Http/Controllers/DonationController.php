<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;

class DonationController extends Controller
{
    public function index()
    {
        $donations = Donation::latest()->get(); // ambil dari DB
    return view('donation', compact('donations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'  => 'required|integer|min:1000',
            'email'   => 'nullable|email',
            'name'    => 'nullable|string|max:255',
            'message' => 'nullable|string|max:500',
        ]);


        Donation::create([
            'name'   => $request->name,
            'email'  => $request->email,
            'amount' => $request->amount,
            'message' => $request->message,
        ]);

        return redirect()->route('donation.success');
    }

    public function success()
    {
        return view('donation_success');
    }
}
