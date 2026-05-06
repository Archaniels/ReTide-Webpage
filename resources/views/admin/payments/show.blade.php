@extends('layouts.admin')

@section('header', 'Payment Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.payments.index') }}" class="text-secondary hover:text-primary transition-colors">
        <i class="fas fa-arrow-left mr-2"></i> Back to History
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Payment Overview -->
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-dark-card border border-gray-800 rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 border-b border-gray-800">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-xl font-bold text-white">Transaction Information</h3>
                    @php
                        $statusClasses = [
                            'settlement' => 'bg-green-500/10 text-green-500',
                            'capture' => 'bg-green-500/10 text-green-500',
                            'pending' => 'bg-yellow-500/10 text-yellow-500',
                            'deny' => 'bg-red-500/10 text-red-500',
                            'cancel' => 'bg-gray-500/10 text-gray-500',
                            'expire' => 'bg-gray-500/10 text-gray-500',
                        ];
                        $class = $statusClasses[$payment->status] ?? 'bg-blue-500/10 text-blue-500';
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-bold uppercase {{ $class }}">
                        {{ $payment->status }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Order ID</p>
                        <p class="text-white font-mono">{{ $payment->order_id }}</p>
                    </div>
                    <div>
                        <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Transaction ID</p>
                        <p class="text-white font-mono">{{ $payment->transaction_id ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Amount</p>
                        <p class="text-2xl font-bold text-primary">Rp {{ number_format($payment->gross_amount, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Payment Date</p>
                        <p class="text-white">{{ $payment->created_at->format('M d, Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-8">
                <h4 class="text-white font-bold mb-4">Raw Midtrans Payload</h4>
                <div class="bg-black/50 rounded-xl p-4 overflow-x-auto border border-gray-800">
                    <pre class="text-xs text-green-400 font-mono">{{ json_encode($payment->payload, JSON_PRETTY_PRINT) }}</pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar / User Info -->
    <div class="space-y-8">
        <div class="bg-dark-card border border-gray-800 rounded-2xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-white mb-6">User Details</h3>
            @if($payment->user)
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center text-black font-bold text-xl mr-4">
                        {{ strtoupper(substr($payment->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-white font-bold">{{ $payment->user->name }}</p>
                        <p class="text-secondary text-sm">{{ $payment->user->email }}</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div>
                        <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">User ID</p>
                        <p class="text-white">#{{ $payment->user->id }}</p>
                    </div>
                    <div>
                        <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-1">Phone Number</p>
                        <p class="text-white">{{ $payment->user->phone_number ?? 'Not provided' }}</p>
                    </div>
                </div>
            @else
                <div class="p-4 bg-dark-lighter rounded-xl border border-gray-800 text-center">
                    <p class="text-secondary italic">Guest Transaction</p>
                </div>
            @endif
        </div>

        <div class="bg-dark-card border border-gray-800 rounded-2xl shadow-xl p-8">
            <h3 class="text-xl font-bold text-white mb-6">Quick Actions</h3>
            <div class="space-y-4">
                <button class="w-full py-3 bg-gray-800 hover:bg-gray-700 text-white rounded-xl transition-colors font-bold flex items-center justify-center">
                    <i class="fas fa-sync-alt mr-2"></i> Update Status
                </button>
                <p class="text-xs text-secondary text-center italic">Status updates usually happen automatically via webhooks.</p>
            </div>
        </div>
    </div>
</div>
@endsection
