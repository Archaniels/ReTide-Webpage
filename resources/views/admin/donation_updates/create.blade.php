@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Update Donasi</h2>

    <form method="POST"
          action="{{ route('admin.donations.updates.store', $donation->id) }}">
        @csrf

        <div>
            <label>Judul Update</label><br>
            <input type="text" name="title" required>
        </div>

        <br>

        <div>
            <label>Deskripsi</label><br>
            <textarea name="description" rows="4" required></textarea>
        </div>

        <br>

        <div>
            <label>Status</label><br>
            <select name="status" required>
                <option value="proses">Proses</option>
                <option value="tersalurkan">Tersalurkan</option>
                <option value="selesai">Selesai</option>
            </select>
        </div>

        <br>

        <button type="submit">Simpan Update</button>
        <a href="{{ route('admin.donations.updates.index', $donation->id) }}">
            Batal
        </a>
    </form>
</div>
@endsection
