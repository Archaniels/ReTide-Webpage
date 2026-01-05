@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Update Donasi</h2>

    <form method="POST"
          action="{{ route('admin.donations.updates.update', [$donation->id, $update->id]) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Judul Update</label><br>
            <input type="text" name="title"
                   value="{{ $update->title }}" required>
        </div>

        <br>

        <div>
            <label>Deskripsi</label><br>
            <textarea name="description" rows="4" required>{{ $update->description }}</textarea>
        </div>

        <br>

        <div>
            <label>Status</label><br>
            <select name="status">
                <option value="pending" @selected($update->status=='pending')>Pending</option>
                <option value="in_progress" @selected($update->status=='in_progress')>In Progress</option>
                <option value="completed" @selected($update->status=='completed')>Completed</option>
            </select>
        </div>

        <br>

        <button type="submit">Update</button>
        <a href="{{ route('admin.donations.updates.index', $update->donation_id) }}">
            Batal
        </a>
    </form>
</div>
@endsection
