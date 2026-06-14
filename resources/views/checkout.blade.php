@extends('layouts.app')

@section('title', 'Checkout | Re:Tide Marketplace')

@section('content')
<div class="checkout-page min-h-screen pt-28 pb-20 bg-background text-white font-sans">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <a href="{{ route('marketplace.index') }}" class="text-brand hover:text-brandHover text-sm font-medium flex items-center transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to Marketplace
            </a>
        </div>

        <h1 class="text-3xl font-bold mb-2 text-brandHover">Secure Checkout</h1>
        <p class="text-gray-400 mb-10">You're one step away from making a positive impact.</p>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Left Column: User Info & Shipping -->
            <div class="lg:col-span-7 space-y-8">
                <!-- Contact Info -->
                <div class="bg-surface rounded-2xl p-8 border border-border">
                    <div class="flex items-center mb-6">
                        <div class="bg-brand bg-opacity-20 text-brand w-10 h-10 rounded-full flex items-center justify-center mr-4">
                            <i class="fas fa-user"></i>
                        </div>
                        <h2 class="text-xl font-semibold">Contact Information</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Full Name</label>
                            <input type="text" value="{{ auth()->user()->name }}" readonly class="w-full bg-surfaceHover border border-border rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand transition-colors cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Email Address</label>
                            <input type="email" value="{{ auth()->user()->email }}" readonly class="w-full bg-surfaceHover border border-border rounded-lg px-4 py-3 text-white focus:outline-none focus:border-brand transition-colors cursor-not-allowed">
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-4"><i class="fas fa-info-circle mr-1"></i> Your information is securely handled and synced with your account.</p>
                </div>

                <!-- Trust Badge Area -->
                <div class="bg-brand/10 rounded-2xl p-6 border border-brand/20 flex items-start space-x-4">
                    <i class="fas fa-shield-alt text-brand text-3xl mt-1"></i>
                    <div>
                        <h3 class="font-semibold text-lg text-white mb-1">Eco-Guaranteed & Secure</h3>
                        <p class="text-sm text-gray-400 leading-relaxed">
                            Every purchase directly supports ocean cleanup initiatives. Your payment is securely processed through Midtrans, ensuring bank-grade security for your transaction.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-5">
                <div class="bg-surface rounded-2xl p-8 border border-border sticky top-32">
                    <h2 class="text-xl font-semibold mb-6 border-b border-border pb-4">Order Summary</h2>

                    <div class="space-y-4 mb-6 max-h-80 overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($cart as $id => $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="w-16 h-16 bg-surfaceActive rounded-lg flex items-center justify-center text-2xl border border-border">
                                    {!! $item['image'] !!}
                                </div>
                                <div>
                                    <h4 class="font-medium text-white">{{ $item['name'] }}</h4>
                                    <p class="text-sm text-gray-400">Qty: {{ $item['quantity'] }}</p>
                                </div>
                            </div>
                            <span class="font-medium text-white">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t border-border pt-4 space-y-3">
                        <div class="flex justify-between text-gray-400">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-400">
                            <span>Eco-Shipping</span>
                            <span class="text-brand">Free</span>
                        </div>
                        <div class="flex justify-between text-xl font-bold text-white pt-4 border-t border-border mt-4">
                            <span>Total</span>
                            <span>Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button type="button" id="pay-button" class="w-full bg-brand hover:bg-brandHover text-black font-bold text-lg py-4 rounded-xl transition-all duration-300 transform hover:-translate-y-1 hover:shadow-[0_4px_20px_rgba(99,207,192,0.3)] flex items-center justify-center">
                        <i class="fas fa-lock mr-2"></i> Pay Securely Now
                    </button>

                    <div class="flex justify-center space-x-3 mt-6 text-gray-500">
                        <i class="fab fa-cc-visa text-2xl"></i>
                        <i class="fab fa-cc-mastercard text-2xl"></i>
                        <i class="fas fa-wallet text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #111111;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #222222;
        border-radius: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #63CFC0;
    }
</style>
@endsection

@section('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route("marketplace.success") }}';
                },
                onPending: function(result) {
                    alert('Payment is pending. Please complete your payment.');
                },
                onError: function(result) {
                    alert('Payment failed. Please try again.');
                },
                onClose: function() {
                    // User closed the popup without finishing payment
                }
            });
        };
    </script>
@endsection
