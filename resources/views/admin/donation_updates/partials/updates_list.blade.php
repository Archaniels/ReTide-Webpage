@forelse ($updates as $update)
    <div style="border:1px solid #ccc; padding:15px; margin-bottom:15px;">
        <h4>{{ $update['title'] }}</h4>
        <p>{{ $update['description'] }}</p>
        <small>Status: <strong>{{ $update['status'] }}</strong></small>
        <br>
        <small>{{ \Carbon\Carbon::parse($update['created_at'])->format('d M Y H:i') }}</small>
    </div>
@empty
    <p>Belum ada update untuk donasi ini.</p>
@endforelse