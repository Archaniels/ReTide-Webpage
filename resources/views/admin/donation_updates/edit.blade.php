@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Update Donasi</h2>

    <form method="POST"
          action="{{ route('admin.donations.updates.update', $update->id) }}">
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
                <option value="proses" @selected($update->status=='proses')>Proses</option>
                <option value="tersalurkan" @selected($update->status=='tersalurkan')>Tersalurkan</option>
                <option value="selesai" @selected($update->status=='selesai')>Selesai</option>
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
