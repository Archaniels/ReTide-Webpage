<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Donasi Berhasil | Re:Tide</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="min-h-screen bg-[#050505] flex items-center justify-center p-4 antialiased selection:bg-[#63cfc0] selection:text-black">

    <div class="bg-[#0f0f0f] border border-[#222] rounded-2xl shadow-2xl p-10 max-w-md w-full text-center">
        
        <!-- Solid, Premium Icon -->
        <div class="flex justify-center mb-8">
            <div class="w-16 h-16 rounded-full bg-[#63cfc0] flex items-center justify-center text-black">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        <h1 class="text-2xl font-semibold text-white mb-3">
            Donasi Berhasil
        </h1>

        <p class="text-gray-400 mb-10 text-sm leading-relaxed px-4">
            Terima kasih atas kontribusi Anda. Donasi Anda sangat berarti untuk mendukung konservasi laut dan keberlanjutan ekosistem.
        </p>

        <div class="flex flex-col gap-3 justify-center">
            <a href="{{ route('donation.index') }}"
               class="w-full py-3 rounded-xl bg-[#63cfc0] text-black font-semibold hover:bg-[#7ae0d3] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#63cfc0] focus-visible:ring-offset-2 focus-visible:ring-offset-[#0f0f0f]">
                Kembali ke Donasi
            </a>

            <a href="{{ route('home') }}"
               class="w-full py-3 rounded-xl border border-[#333] text-white font-medium hover:bg-[#1a1a1a] transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#63cfc0]">
                Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>
