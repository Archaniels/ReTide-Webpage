@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-2xl mx-auto px-6">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.donations.updates.index', $donation->id) }}" class="text-blue-600 hover:text-blue-700 font-semibold mb-4 inline-block">← Kembali ke Perjalanan</a>
            <h1 class="text-3xl font-bold text-gray-900">Tambah Update Donasi</h1>
            <p class="text-gray-600 mt-2">Donasi: <strong>{{ $donation->name }}</strong> (Rp {{ number_format($donation->amount, 0, ',', '.') }})</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-lg p-8">
            <form method="POST" action="{{ route('admin.donations.updates.store', $donation->id) }}" class="space-y-6">
                @csrf

                <!-- Judul -->
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-900 mb-2">Judul Update</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Masukkan judul update" required>
                    @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi</label>
                    <textarea id="description" name="description" value="{{ old('description') }}"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Masukkan deskripsi update" rows="5" required></textarea>
                    @error('description') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-semibold text-gray-900 mb-2">Status</label>
                    <select id="status" name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            required>
                        <option value="pending" selected>⏳ Pending</option>
                        <option value="in_progress">🔄 In Progress</option>
                        <option value="completed">✅ Completed</option>
                    </select>
                    @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-6 border-t border-gray-200">
                    <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                        ✅ Simpan Update
                    </button>
                    <a href="{{ route('admin.donations.updates.index', $donation->id) }}" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-lg font-semibold transition text-center">
                        ✕ Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
