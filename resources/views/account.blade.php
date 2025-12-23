<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Account - Re:Tide</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #000000;
            color: white;
        }
        .text-tosca { color: #7ae0d3; }
        /* Background input dibuat hitam agar kontras dengan container abu-abu */
        .bg-input { background-color: #000000; border: 1px solid #333; }
        .bg-input:focus { border-color: #7ae0d3; outline: none; }
        .nav-link:hover { color: #7ae0d3; text-decoration: underline; }
        /* Container untuk membungkus form */
        .card-container {
            background-color: #1a1a1a; /* Abu-abu sangat gelap */
            border-radius: 12px;
            padding: 2.5rem;
        }
    </style>
</head>

<body>
    <header class="w-full py-6">
        <div class="flex flex-col items-center">
            <img src="{{ asset('assets/img/ReTide_Logo.png') }}" class="h-8 mb-6" alt="ReTide Logo">
            <nav>
                <ul class="flex space-x-8 text-sm font-medium">
                    <li><a href="/" class="nav-link">Home</a></li>
                    <li><a href="/about" class="nav-link">About Us</a></li>
                    <li><a href="/blog" class="nav-link">Blog</a></li>
                    <li><a href="/contact" class="nav-link">Contact</a></li>
                    <li><a href="/account" class="text-tosca underline">Account</a></li>
                    <li><a href="/marketplace" class="nav-link">Marketplace</a></li>
                    <li><a href="/donation" class="nav-link">Donation</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="max-w-screen-xl mx-auto px-10 mt-10 mb-20">
        <div class="mb-10">
            <h1 class="text-6xl font-bold text-tosca mb-2">Account</h1>
            <p class="text-xl">Halo, <span class="font-bold text-tosca">{{ Auth::user()->name }}</span></p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-tosca/10 border border-tosca text-tosca rounded transition-all">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-container">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
                
                <form action="{{ route('account.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <h2 class="text-2xl font-semibold mb-6 border-b border-gray-800 pb-2">Informasi Profil</h2>
                    
                    <div class="flex flex-col">
                        <label class="text-xs text-gray-400 uppercase tracking-wider mb-2">Username</label>
                        <input type="text" name="username" value="{{ old('username', $user->name) }}" class="bg-input p-3 rounded-md w-full text-sm">
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs text-gray-400 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="bg-input p-3 rounded-md w-full text-sm" readonly>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-xs text-gray-400 uppercase tracking-wider mb-2">No Telp</label>
                        <input type="text" name="notelp" value="{{ old('notelp', $user->phone_number) }}" class="bg-input p-3 rounded-md w-full text-sm">
                    </div>

                    <button type="submit" class="bg-[#006a94] hover:bg-[#005a7d] px-8 py-3 rounded-md font-bold transition text-sm w-full md:w-auto">
                        Simpan Perubahan
                    </button>
                </form>

                <div class="space-y-10">
                    <form action="{{ route('account.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <h2 class="text-2xl font-semibold mb-6 border-b border-gray-800 pb-2">Ganti Password</h2>
                        
                        <div class="space-y-4">
                            <input type="password" name="current_password" placeholder="Password Lama" 
                                   class="bg-input p-3 rounded-md w-full text-sm @error('current_password') border-red-500 @enderror">
                            
                            <input type="password" name="new_password" placeholder="Password Baru" 
                                   class="bg-input p-3 rounded-md w-full text-sm @error('new_password') border-red-500 @enderror">
                            
                            <input type="password" name="new_password_confirmation" placeholder="Konfirmasi Password Baru" 
                                   class="bg-input p-3 rounded-md w-full text-sm">
                        </div>
                        
                        <button type="submit" class="border border-tosca text-tosca hover:bg-tosca hover:text-black px-8 py-3 rounded-md font-bold transition text-sm">
                            Update Password
                        </button>
                    </form>

                    <div class="pt-8 border-t border-gray-800">
                        <h2 class="text-lg font-bold text-red-500 mb-2">Hapus Akun</h2>
                        <p class="text-gray-500 text-xs mb-4">Tindakan ini permanen. Seluruh data Anda akan dihapus dari sistem kami.</p>
                        
                        <div class="flex flex-col space-y-3">
                            <form action="{{ route('account.destroy') }}" method="POST" onsubmit="return confirm('Yakin ingin hapus?')">
                                @csrf @method('DELETE')
                                <button class="text-red-500 text-sm hover:underline transition font-medium">Hapus akun saya secara permanen</button>
                            </form>
                            
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="text-gray-500 text-sm hover:text-white underline transition italic">Keluar (Logout)</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>