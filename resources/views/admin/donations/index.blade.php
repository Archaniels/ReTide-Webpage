@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Donasi</h2>

    @if($donations->count() > 0)
        <table border="1" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Donatur</th>
                    <th>Email</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($donations as $donation)
                    <tr>
                        <td>{{ $donation->id }}</td>
                        <td>{{ $donation->name ?? 'Anonim' }}</td>
                        <td>{{ $donation->email ?? '-' }}</td>
                        <td>Rp {{ number_format($donation->amount, 0, ',', '.') }}</td>
                        <td>{{ $donation->created_at->format('d M Y H:i') }}</td>
                        <td>
                            <button class="toggle-timeline" data-donation-id="{{ $donation->id }}">
                                Lihat Perjalanan
                            </button>
                            <a href="{{ route('admin.donations.updates.create', $donation->id) }}" style="margin-left:10px;">
                                Tambah Update
                            </a>
                            <form method="POST" action="{{ route('admin.donations.destroy', $donation->id) }}" style="display:inline; margin-left:10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus donasi ini?')" style="background:red; color:white; border:none; padding:5px 10px; cursor:pointer;">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    <tr id="timeline-{{ $donation->id }}" style="display:none;">
                        <td colspan="6">
                            <div class="timeline-container" data-donation-id="{{ $donation->id }}">
                                <h4>Perjalanan Donasi</h4>
                                <div class="timeline-content">
                                    <!-- Updates will be loaded here -->
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>Belum ada donasi.</p>
    @endif
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.toggle-timeline').click(function() {
        var donationId = $(this).data('donation-id');
        var timelineRow = $('#timeline-' + donationId);
        var timelineContent = timelineRow.find('.timeline-content');

        if (timelineRow.is(':visible')) {
            timelineRow.hide();
        } else {
            // Load updates if not loaded yet
            if (timelineContent.html().trim() === '') {
                $.ajax({
                    url: '{{ route("admin.donations.updates.index", ":id") }}'.replace(':id', donationId),
                    type: 'GET',
                    success: function(data) {
                        // Extract updates from the response
                        var updates = $(data).find('.donation-updates-list').html();
                        if (updates) {
                            timelineContent.html(updates);
                        } else {
                            timelineContent.html('<p>Belum ada update untuk donasi ini.</p>');
                        }
                    },
                    error: function() {
                        timelineContent.html('<p>Error loading updates.</p>');
                    }
                });
            }
            timelineRow.show();
        }
    });
});
</script>
@endsection