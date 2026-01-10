@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-6">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.donations.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold mb-4 inline-block">← Kembali ke Daftar</a>
            <h1 class="text-3xl font-bold text-gray-900">Edit Donasi</h1>
            <p class="text-gray-600 mt-2">Perbarui informasi donasi #{{ $donation->id }}</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form method="POST" action="{{ route('admin.donations.update', $donation->id) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama Donatur -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-900 mb-2">Nama Donatur</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $donation->name) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan nama donatur" required>
                    @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-900 mb-2">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $donation->email) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan email" required>
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Nominal -->
                <div>
                    <label for="amount" class="block text-sm font-semibold text-gray-900 mb-2">Nominal Donasi (Rp)</label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount', $donation->amount) }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan nominal" min="1000" required>
                    @error('amount') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Pesan -->
                <div>
                    <label for="message" class="block text-sm font-semibold text-gray-900 mb-2">Pesan</label>
                    <textarea name="message" id="message"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Masukkan pesan (opsional)" rows="4">{{ old('message', $donation->message) }}</textarea>
                    @error('message') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        💾 Update Donasi
                    </button>
                    <a href="{{ route('admin.donations.index') }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold transition text-center">
                        ✕ Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection