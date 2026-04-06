@extends('layouts.admin')

@section('header', 'Donation Journey')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('admin.donations.index') }}" class="text-secondary hover:text-primary transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Donations
        </a>
        <a href="{{ route('admin.donations.updates.create', $donation->id) }}" class="bg-primary hover:bg-primary/90 text-black font-bold py-2 px-4 rounded-lg transition-all text-sm">
            <i class="fas fa-plus mr-1 text-xs"></i> Add Journey Update
        </a>
    </div>

    <div class="bg-dark-card border border-gray-800 rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-800 bg-dark-lighter/50 flex flex-wrap gap-6 items-center">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-primary/20 text-primary flex items-center justify-center mr-3 font-bold">
                    #{{ $donation->id }}
                </div>
                <div>
                    <div class="text-xs text-secondary font-bold uppercase">Donation ID</div>
                    <div class="text-white font-mono">#{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>
            
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center mr-3">
                    <i class="fas fa-user"></i>
                </div>
                <div>
                    <div class="text-xs text-secondary font-bold uppercase">Donor</div>
                    <div class="text-white">{{ $donation->name ?? 'Anonymous' }}</div>
                </div>
            </div>

            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center mr-3">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <div>
                    <div class="text-xs text-secondary font-bold uppercase">Amount</div>
                    <div class="text-primary font-bold">Rp {{ number_format($donation->amount, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        <div class="p-8">
            <h3 class="text-xl font-bold text-white mb-8 flex items-center">
                <i class="fas fa-history text-primary mr-3"></i> Journey History
            </h3>

            <div class="donation-updates-list relative">
                @include('admin.donation_updates.partials.updates_list', ['updates' => $updates])
            </div>
        </div>
    </div>
</div>
@endsection
