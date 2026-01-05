@forelse ($updates as $update)
    <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">
        <h4>{{ $update['title'] }}</h4>
        <p>{{ $update['description'] }}</p>
        <small>Status: <strong>{{ $update['status'] }}</strong></small>
        <br>
        <small>{{ \Carbon\Carbon::parse($update['created_at'])->format('d M Y H:i') }}</small>
        <br>
        <a href="{{ route('admin.donations.updates.edit', [$donation->id, $update['id']]) }}" style="margin-right:10px;">Edit</a>
        <form method="POST" action="{{ route('admin.donations.updates.destroy', [$donation->id, $update['id']]) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" onclick="return confirm('Yakin hapus update ini?')" style="background:red; color:white; border:none; padding:2px 5px;">Hapus</button>
        </form>
    </div>
@empty
    <p>Belum ada update untuk donasi ini.</p>
@endforelse