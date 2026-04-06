@extends('layouts.admin')

@section('header', 'Donation Management')

@section('content')
<div class="mb-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-dark-card border border-gray-800 rounded-2xl p-6 shadow-lg">
            <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-2">Total Received</p>
            <p class="text-3xl font-bold text-white">Rp {{ number_format($donations->sum('amount'), 0, ',', '.') }}</p>
        </div>
        <div class="bg-dark-card border border-gray-800 rounded-2xl p-6 shadow-lg">
            <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-2">Donation Count</p>
            <p class="text-3xl font-bold text-primary">{{ $donations->count() }}</p>
        </div>
        <div class="bg-dark-card border border-gray-800 rounded-2xl p-6 shadow-lg">
            <p class="text-secondary text-xs font-bold uppercase tracking-wider mb-2">Recent (Today)</p>
            <p class="text-3xl font-bold text-white">{{ $donations->where('created_at', '>=', now()->startOfDay())->count() }}</p>
        </div>
    </div>
</div>

<div class="bg-dark-card border border-gray-800 rounded-2xl shadow-xl overflow-hidden">
    <div class="p-6 border-b border-gray-800 flex justify-between items-center bg-dark-lighter/50">
        <h3 class="text-lg font-bold text-white">Donation List</h3>
        <div class="flex space-x-2">
            <!-- Search or Filter could go here -->
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-dark-lighter text-secondary text-xs font-bold uppercase tracking-widest border-b border-gray-800">
                    <th class="px-6 py-4">ID</th>
                    <th class="px-6 py-4">Donor</th>
                    <th class="px-6 py-4">Contact</th>
                    <th class="px-6 py-4 text-right">Amount</th>
                    <th class="px-6 py-4">Date</th>
                    <th class="px-6 py-4 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-800">
                @forelse($donations as $donation)
                    <tr class="hover:bg-gray-800/30 transition-colors duration-150">
                        <td class="px-6 py-4 text-sm font-mono text-secondary">#{{ $donation->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-white">{{ $donation->name ?? 'Anonymous' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-secondary">
                            {{ $donation->email ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-right font-bold text-primary">
                            Rp {{ number_format($donation->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-sm text-secondary">
                            {{ $donation->created_at->format('d M Y') }}
                            <div class="text-xs opacity-50">{{ $donation->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center space-x-2">
                                <button class="toggle-timeline p-2 text-secondary hover:text-primary transition-colors" 
                                        data-donation-id="{{ $donation->id }}" title="View Journey">
                                    <i class="fas fa-history"></i>
                                </button>
                                <a href="{{ route('admin.donations.updates.create', $donation->id) }}" 
                                   class="p-2 text-secondary hover:text-blue-400 transition-colors" title="Add Update">
                                    <i class="fas fa-plus-circle"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.donations.destroy', $donation->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this donation?')" 
                                            class="p-2 text-secondary hover:text-red-500 transition-colors" title="Delete">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr id="timeline-{{ $donation->id }}" class="hidden bg-dark-lighter/30">
                        <td colspan="6" class="px-8 py-6">
                            <div class="timeline-container bg-dark border border-gray-800 rounded-xl p-6 shadow-inner" data-donation-id="{{ $donation->id }}">
                                <div class="flex items-center justify-between mb-6">
                                    <h4 class="text-sm font-bold uppercase tracking-wider text-primary flex items-center">
                                        <i class="fas fa-route mr-2"></i> Donation Journey
                                    </h4>
                                    <span class="text-xs text-secondary italic">Updates and milestones</span>
                                </div>
                                <div class="timeline-content space-y-4">
                                    <div class="flex justify-center py-4">
                                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-primary"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-secondary">
                            <i class="fas fa-inbox text-4xl mb-4 opacity-20"></i>
                            <p>No donations found yet.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.toggle-timeline').click(function() {
        const btn = $(this);
        const donationId = btn.data('donation-id');
        const timelineRow = $('#timeline-' + donationId);
        const timelineContent = timelineRow.find('.timeline-content');

        if (timelineRow.is(':visible')) {
            timelineRow.fadeOut(200, function() {
                $(this).addClass('hidden');
                btn.removeClass('text-primary').addClass('text-secondary');
            });
        } else {
            timelineRow.removeClass('hidden').hide().fadeIn(300);
            btn.addClass('text-primary').removeClass('text-secondary');

            // Load updates if it looks like we only have the loader
            if (timelineContent.find('.animate-spin').length > 0) {
                $.ajax({
                    url: '{{ route("admin.donations.updates.index", ":id") }}'.replace(':id', donationId),
                    type: 'GET',
                    success: function(data) {
                        const updates = $(data).find('.donation-updates-list').html();
                        if (updates && updates.trim() !== '') {
                            timelineContent.hide().html(updates).fadeIn(400);
                        } else {
                            timelineContent.html('<div class="text-center py-4 text-secondary italic"><i class="fas fa-info-circle mr-2"></i>No updates recorded for this donation yet.</div>');
                        }
                    },
                    error: function() {
                        timelineContent.html('<div class="text-center py-4 text-red-400"><i class="fas fa-exclamation-triangle mr-2"></i>Error loading updates. Please try again.</div>');
                    }
                });
            }
        }
    });
});
</script>

<style>
    /* Styling for updates list when injected */
    .timeline-content .update-item {
        @apply border-l-2 border-primary pl-4 py-2 relative;
    }
    .timeline-content .update-item::before {
        content: "";
        @apply absolute -left-1.5 top-3 w-3 h-3 bg-primary rounded-full;
    }
</style>
@endsection