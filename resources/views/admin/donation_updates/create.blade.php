@extends('layouts.admin')

@section('header', 'Add Donation Update')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.donations.index') }}" class="text-secondary hover:text-primary transition-colors flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Back to Donations
        </a>
    </div>

    <div class="bg-dark-card border border-gray-800 rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6 border-b border-gray-800 bg-dark-lighter/50">
            <h3 class="text-lg font-bold text-white">Update for Donation #{{ $donation->id }}</h3>
            <p class="text-xs text-secondary mt-1">Donor: <span class="text-primary font-bold">{{ $donation->name ?? 'Anonymous' }}</span></p>
        </div>

        <form method="POST" action="{{ route('admin.donations.updates.store', $donation->id) }}" class="p-8 space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-secondary uppercase tracking-wider mb-2">Update Title</label>
                <input type="text" name="title" required 
                       class="w-full bg-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-primary transition-all placeholder-gray-600"
                       placeholder="e.g., Funds received or Project phase started">
            </div>

            <div>
                <label class="block text-sm font-bold text-secondary uppercase tracking-wider mb-2">Description</label>
                <textarea name="description" rows="5" required 
                          class="w-full bg-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-primary transition-all placeholder-gray-600"
                          placeholder="Provide detailed information about this update..."></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-bold text-secondary uppercase tracking-wider mb-2">Status</label>
                    <div class="relative">
                        <select name="status" required 
                                class="w-full bg-dark border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-primary appearance-none transition-all">
                            <option value="proses">Proses (Processing)</option>
                            <option value="tersalurkan">Tersalurkan (Distributed)</option>
                            <option value="selesai">Selesai (Completed)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-secondary">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-4 flex items-center space-x-4">
                <button type="submit" class="bg-primary hover:bg-primary/90 text-black font-bold py-3 px-8 rounded-xl transition-all shadow-lg shadow-primary/20">
                    Save Update
                </button>
                <a href="{{ route('admin.donations.index') }}" class="text-secondary hover:text-white font-medium px-4 py-2 transition-colors">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
