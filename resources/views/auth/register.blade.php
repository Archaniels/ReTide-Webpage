<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Register</title>
</head>
<body class="bg-[#0a0a0a] text-white flex items-center justify-center min-h-screen">
    <div class="w-full max-w-sm p-6">
        <h1 class="text-4xl font-bold mb-8">Register</h1>
        
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm mb-2">Alamat email</label>
                <input type="email" name="email" class="w-full bg-[#121212] border border-gray-800 rounded-lg p-3 focus:outline-none focus:border-cyan-500" placeholder="📧" required>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm mb-2">Password</label>
                <input type="password" name="password" class="w-full bg-[#121212] border border-gray-800 rounded-lg p-3 focus:outline-none focus:border-cyan-500" placeholder="🔒" required>
            </div>

            <div class="flex items-center mb-6 text-sm text-gray-400">
                <input type="checkbox" name="remember" class="mr-2"> Remember Password
            </div>

            <button type="submit" class="w-full bg-[#006a94] hover:bg-[#005a7d] text-white font-semibold py-3 rounded-lg transition">Lanjut</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-400">
            Already have an account? <a href="{{ route('login') }}" class="text-cyan-500 hover:underline">Sign In!</a>
        </p>
    </div>
</body>
</html>