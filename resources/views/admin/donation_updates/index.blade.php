@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Perjalanan Donasi</h2>

    <p>
        <strong>Donasi ID:</strong> {{ $donation->id }} <br>
        <strong>Donatur:</strong> {{ $donation->name ?? 'Anonim' }} <br>
        <strong>Nominal:</strong> Rp {{ number_format($donation->amount) }}
    </p>

    <a href="{{ route('admin.donations.updates.create', $donation->id) }}">
        + Tambah Update
    </a>

    <hr>

    <div class="donation-updates-list">
        @include('admin.donation_updates.partials.updates_list', ['updates' => $updates])
    </div>
</div>
@endsection
