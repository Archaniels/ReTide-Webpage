@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="px-8 py-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Kelola Donasi</h1>
                    <p class="text-gray-600 mt-2">Lihat, edit, dan kelola semua donasi yang masuk</p>
                </div>
                <a href="{{ route('admin.donations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                    + Tambah Donasi Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="px-8 py-8">
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($donations->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($donations as $donation)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-4">
                            <h3 class="text-lg font-bold">{{ $donation->name ?? 'Donatur Anonim' }}</h3>
                            <p class="text-blue-100 text-sm">ID: #{{ $donation->id }}</p>
                        </div>

                        <!-- Card Body -->
                        <div class="px-6 py-4 space-y-3">
                            <div>
                                <span class="text-sm text-gray-600">Email</span>
                                <p class="text-gray-900 font-semibold">{{ $donation->email ?? '-' }}</p>
                            </div>

                            <div>
                                <span class="text-sm text-gray-600">Nominal Donasi</span>
                                <p class="text-2xl font-bold text-blue-600">Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>
                            </div>

                            <div>
                                <span class="text-sm text-gray-600">Tanggal Donasi</span>
                                <p class="text-gray-900">{{ $donation->created_at->format('d M Y - H:i') }}</p>
                            </div>

                            @if($donation->message)
                                <div>
                                    <span class="text-sm text-gray-600">Pesan</span>
                                    <p class="text-gray-700 italic">{{ $donation->message }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Timeline Section -->
                        <div class="border-t border-gray-200 px-6 py-4">
                            <button class="toggle-timeline w-full bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded font-semibold transition text-sm"
                                    data-donation-id="{{ $donation->id }}">
                                👁️ Lihat Perjalanan Donasi
                            </button>
                        </div>

                        <!-- Action Buttons -->
                        <div class="border-t border-gray-200 px-6 py-4 flex gap-2">
                            <a href="{{ route('admin.donations.edit', $donation->id) }}"
                               class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded font-semibold transition text-center text-sm">
                                ✏️ Edit
                            </a>
                            <a href="{{ route('admin.donations.updates.create', $donation->id) }}"
                               class="flex-1 bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded font-semibold transition text-center text-sm">
                                📝 Tambah Update
                            </a>
                            <form method="POST" action="{{ route('admin.donations.destroy', $donation->id) }}" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus donasi ini?')"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded font-semibold transition text-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>

                        <!-- Timeline Details (Hidden) -->
                        <div id="timeline-{{ $donation->id }}" class="hidden border-t border-gray-200 px-6 py-4 bg-gray-50">
                            <h4 class="font-bold text-gray-900 mb-4">Perjalanan Donasi</h4>
                            <div class="timeline-content text-sm text-gray-600">
                                <!-- Updates akan dimuat di sini -->
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="text-6xl mb-4">📭</div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Belum Ada Donasi</h3>
                <p class="text-gray-600 mb-6">Mulai dengan menambahkan donasi baru</p>
                <a href="{{ route('admin.donations.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold inline-block transition">
                    Tambah Donasi Pertama
                </a>
            </div>
        @endif
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    console.log('Toggle timeline script loaded');
    $('.toggle-timeline').click(function() {
        console.log('Button clicked!');
        var donationId = $(this).data('donation-id');
        console.log('Donation ID:', donationId);
        var timelineRow = $('#timeline-' + donationId);
        var timelineContent = timelineRow.find('.timeline-content');

        if (timelineRow.is(':hidden')) {
            $.ajax({
                url: '{{ route("admin.donations.updates.index", ":id") }}'.replace(':id', donationId),
                type: 'GET',
                success: function(data) {
                    console.log('AJAX success, data:', data);
                    var updates = $(data).find('.donation-updates-list').html();
                    if (updates) {
                        timelineContent.html(updates);
                    } else {
                        timelineContent.html('<p class="text-gray-500">Belum ada update untuk donasi ini.</p>');
                    }
                    timelineRow.removeClass('hidden');
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', status, error);
                    timelineContent.html('<p class="text-red-500">Error loading updates: ' + error + '</p>');
                    timelineRow.removeClass('hidden');
                }
            });
        } else {
            timelineRow.addClass('hidden');
        }
    });
});
</script>
@endsection