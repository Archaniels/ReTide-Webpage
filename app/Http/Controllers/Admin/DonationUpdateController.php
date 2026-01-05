<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DonationUpdateController extends Controller
{
    public function index(Donation $donation)
    {
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

        if (request()->ajax()) {
            return view('admin.donation_updates.partials.updates_list', compact('updates'));
        }

        return view('admin.donation_updates.index', compact('donation', 'updates'));
    }

    public function create(Donation $donation)
    {
        return view('admin.donation_updates.create', compact('donation'));
    }

    public function store(Request $request, Donation $donation)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
        ]);

        // Post to Node.js API
        try {
            $response = Http::post("http://localhost:3000/donation-updates", [
                'donation_id' => $donation->id,
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            if ($response->successful()) {
                return redirect()
                    ->route('admin.donations.updates.index', $donation->id)
                    ->with('success', 'Update donasi berhasil ditambahkan');
            } else {
                return back()->withErrors(['error' => 'Gagal menambah update']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error connecting to Node.js API']);
        }
    }

    public function edit(Donation $donation, $updateId)
    {
        // Fetch update from Node.js API
        $update = null;
        try {
            $response = Http::get("http://localhost:3000/donation-updates/single/{$updateId}");
            if ($response->successful()) {
                $update = (object) $response->json();
            }
        } catch (\Exception $e) {
            // Handle error
        }

        if (!$update) {
            abort(404);
        }

        return view('admin.donation_updates.edit', compact('donation', 'update'));
    }

    public function update(Request $request, Donation $donation, $updateId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
        ]);

        // Put to Node.js API
        try {
            $response = Http::put("http://localhost:3000/donation-updates/{$updateId}", [
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            if ($response->successful()) {
                return redirect()
                    ->route('admin.donations.updates.index', $donation->id)
                    ->with('success', 'Update donasi berhasil diperbarui');
            } else {
                return back()->withErrors(['error' => 'Gagal memperbarui update']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error connecting to Node.js API']);
        }
    }

    public function destroy(Donation $donation, $updateId)
    {
        // Delete from Node.js API
        try {
            $response = Http::delete("http://localhost:3000/donation-updates/{$updateId}");

            if ($response->successful()) {
                return redirect()
                    ->route('admin.donations.updates.index', $donation->id)
                    ->with('success', 'Update donasi berhasil dihapus');
            } else {
                return back()->withErrors(['error' => 'Gagal menghapus update']);
            }
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error connecting to Node.js API']);
        }
    }
}
