<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Donasi Berhasil | Re:Tide</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-[#041f2b] to-[#020f16] flex items-center justify-center">

    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-2xl shadow-2xl p-10 max-w-lg w-full text-center">
        
        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-full bg-[#7ae0d3]/20 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-[#7ae0d3]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-2xl md:text-3xl font-semibold text-white mb-3">
            Donasi Berhasil 💙
        </h1>

        <!-- Description -->
        <p class="text-gray-300 mb-8 leading-relaxed">
            Terima kasih atas kontribusi Anda.  
            Donasi Anda sangat berarti untuk mendukung konservasi laut dan keberlanjutan ekosistem.
        </p>

        <!-- Actions -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('donation.index') }}"
               class="px-6 py-3 rounded-full bg-[#7ae0d3] text-[#02212f] font-medium hover:bg-[#67cfc2] transition">
                Kembali ke Donasi
            </a>

            <a href="{{ route('home') }}"
               class="px-6 py-3 rounded-full border border-white/30 text-white hover:bg-white/10 transition">
                Ke Home
            </a>
        </div>
    </div>

</body>
</html>
