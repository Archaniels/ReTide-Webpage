<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login</title>
</head>

<body class="bg-[#0a0a0a] text-white flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm p-6">
        <h1 class="text-4xl font-bold mb-8">Login</h1>

        @if($errors->any())
            <p class="text-red-500 text-sm mb-4">{{ $errors->first() }}</p>
        @endif

        @if(session('success'))
            <p class="text-tosca text-sm mb-4 bg-tosca/10 p-2 rounded border border-tosca">
                {{ session('success') }}
            </p>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm mb-2">Alamat email</label>
                <input type="email" name="email"
                    class="w-full bg-[#121212] border border-gray-800 rounded-lg p-3 focus:outline-none focus:border-cyan-500"
                    placeholder="📧" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm mb-2">Password</label>
                <input type="password" name="password"
                    class="w-full bg-[#121212] border border-gray-800 rounded-lg p-3 focus:outline-none focus:border-cyan-500"
                    placeholder="🔒" required>
            </div>

            <div class="flex items-center mb-6 text-sm text-gray-400">
                <input type="checkbox" name="remember" class="mr-2"> Remember Password
            </div>

            <button type="submit"
                class="w-full bg-[#006a94] hover:bg-[#005a7d] text-white font-semibold py-3 rounded-lg transition">Lanjut</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-400">
            Don't have an account? <a href="{{ route('register') }}" class="text-cyan-500 hover:underline">Sign up!</a>
        </p>
    </div>
</body>

</html>