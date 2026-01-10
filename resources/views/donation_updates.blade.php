@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Perjalanan Donasi</h2>
    <p>Donasi oleh: {{ $donation->name }} - Rp {{ number_format($donation->amount, 0, ',', '.') }}</p>

    @if(count($updates) > 0)
        <div class="timeline">
            @foreach($updates as $update)
                <div class="timeline-item">
                    <h4>{{ $update['title'] }}</h4>
                    <p>{{ $update['description'] }}</p>
                    <small>Status: {{ $update['status'] }} | Tanggal: {{ $update['created_at'] ?? 'N/A' }}</small>
                </div>
            @endforeach
        </div>
    @else
        <p>Belum ada update untuk donasi ini.</p>
    @endif

    <a href="{{ route('donation.index') }}">Kembali ke Donasi</a>
</div>
@endsection