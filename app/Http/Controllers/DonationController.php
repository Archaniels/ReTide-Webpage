<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\DonationUpdate;
use Illuminate\Support\Facades\Http;


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

    public function store(Request $request)
    {
        $request->validate([
            'amount'  => 'required|integer|min:1000',
            'email'   => 'nullable|email',
            'name'    => 'nullable|string|max:255',
            'message' => 'nullable|string|max:500',
        ]);


        Donation::create([
            'name'   => $request->name ?: auth()->user()->name,
            'email'  => $request->email ?: auth()->user()->email,
            'amount' => $request->amount,
            'message' => $request->message,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('donation.success');
    }

    public function success()
    {
        return view('donation_success');
    }

    public function showUpdates(Donation $donation)
    {
        // Pastikan user adalah pemilik donasi atau admin
        if ($donation->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        // Fetch updates from Node.js API
        $updates = [];
        try {
            $response = Http::get("http://localhost:3000/donation-updates/{$donation->id}");
            if ($response->successful()) {
                $updates = $response->json();
            }
        } catch (\Exception $e) {
            $updates = [];
        }

        return view('donation_updates', compact('donation', 'updates'));
    }

    public function adminIndex()
    {
        $donations = Donation::with('user')->latest()->get();
        return view('admin.donations.index', compact('donations'));
    }

    public function adminCreate()
    {
        return view('admin.donations.create');
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'amount' => 'required|integer|min:1000',
            'message' => 'nullable|string|max:500',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Donation::create($request->only(['name', 'email', 'amount', 'message', 'user_id']));

        return redirect()->route('admin.donations.index')->with('success', 'Donasi berhasil dibuat');
    }

    public function adminDestroy(Donation $donation)
    {
        $donation->delete();
        return redirect()->route('admin.donations.index')->with('success', 'Donasi berhasil dihapus');
    }

    public function adminEdit(Donation $donation)
    {
        return view('admin.donations.edit', compact('donation'));
    }

    public function adminUpdate(Request $request, Donation $donation)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'amount' => 'required|integer|min:1000',
            'message' => 'nullable|string|max:500',
        ]);

        $donation->update($request->only(['name', 'email', 'amount', 'message']));

        return redirect()->route('admin.donations.index')->with('success', 'Donasi berhasil diperbarui');
    }
}
