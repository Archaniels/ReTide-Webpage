@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">Perjalanan Donasi</h2>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <p class="mb-2"><strong class="text-gray-700">Donasi ID:</strong> #{{ $donation->id }}</p>
            <p class="mb-2"><strong class="text-gray-700">Donatur:</strong> {{ $donation->name ?? 'Anonim' }}</p>
            <p class="mb-4"><strong class="text-gray-700">Nominal:</strong> Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
            <a href="{{ route('admin.donations.updates.create', $donation->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded font-semibold transition">
                + Tambah Update
            </a>
        </div>

        <div class="donation-updates-list">
            @include('admin.donation_updates.partials.updates_list', ['updates' => $updates])
        </div>
    </div>
@endsection
