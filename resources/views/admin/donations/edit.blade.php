@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Donasi</h2>

    <form method="POST" action="{{ route('admin.donations.update', $donation->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama Donatur</label>
            <input type="text" name="name" id="name" value="{{ old('name', $donation->name) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $donation->email) }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="amount">Nominal (Rp)</label>
            <input type="number" name="amount" id="amount" value="{{ old('amount', $donation->amount) }}" class="form-control" min="1000" required>
        </div>

        <div class="form-group">
            <label for="message">Pesan</label>
            <textarea name="message" id="message" class="form-control">{{ old('message', $donation->message) }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Donasi</button>
        <a href="{{ route('admin.donations.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection