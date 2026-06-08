<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About ReTide</title>

    <!-- Style -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/styles.css') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <!-- Lenis by Darkroom Engineering -->
    <script src="https://unpkg.com/lenis@1.3.14/dist/lenis.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/lenis@1.3.15/dist/lenis.css">

    <!-- GSAP + ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- Custom Scripts -->
    <script src="{{ URL::asset('assets/js/script.js') }}"></script>
    <script src="{{ URL::asset('assets/js/homepage-animation.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>

<body class="defaultTheme hide-scrollbar">
    <div class="about-page">
        <!-- Navbar -->
    <header class="fixed w-full z-50 top-0 start-0 border-b border-white/5 bg-black/50 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('assets/img/ReTide_Logo.png') }}" class="h-8" alt="ReTide Logo" />
                    </a>
                </div>
                <nav class="hidden md:block">
                    <ul class="flex space-x-8 text-sm font-medium">
                        <li><a href="/" class="text-gray-300 hover:text-white transition-colors">Home</a></li>
                        <li><a href="/about" class="text-[#63cfc0] hover:text-white transition-colors">About</a></li>
                        <li><a href="/contact" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                        <li><a href="/account" class="text-gray-300 hover:text-white transition-colors">Account</a></li>
                        <li><a href="/blog" class="text-gray-300 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="/marketplace" class="text-gray-300 transition-colors">Marketplace</a></li>
                        <li><a href="/donation" class="text-gray-300 hover:text-white transition-colors">Donation</a></li>
                    </ul>
                </nav>
                <div class="flex items-center space-x-4">
                    <a href="/account" class="text-gray-300 hover:text-white transition-colors">
                        <i class="fas fa-user-circle text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </header>

        <!-- Main Content -->
        <main class="pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto space-y-24">
            
            <!-- Hero Section -->
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <h1 class="text-5xl md:text-6xl font-bold text-[#63CFC0] tracking-tight leading-tight text-balance">
                        About Us
                    </h1>
                    <p class="text-xl md:text-2xl text-gray-300 font-light max-w-xl text-pretty leading-relaxed">
                        Membantu masyarakat untuk menjaga ekosistem laut melalui aksi nyata.
                    </p>
                </div>
                <div class="relative w-full h-[400px] md:h-[500px] rounded-3xl overflow-hidden shadow-2xl">
                    <img src="assets/img/about_us_decoration.jpg" class="absolute inset-0 w-full h-full object-cover" alt="About Us Decoration">
                    <div class="absolute inset-0 bg-gradient-to-t from-neutral-950/80 to-transparent"></div>
                </div>
            </section>

            <!-- Narrative / Editorial Grid -->
            <section class="grid grid-cols-1 md:grid-cols-12 gap-12 border-t border-gray-800 pt-16">
                <!-- Siapa Kami -->
                <div class="md:col-span-6 space-y-4">
                    <h2 class="text-xs uppercase tracking-widest text-[#63CFC0] font-semibold">Identitas</h2>
                    <h3 class="text-3xl font-semibold text-white">Siapa Kami?</h3>
                    <p class="text-gray-400 leading-relaxed text-pretty text-lg">
                        Kami percaya bahwa pelestarian kehidupan dan ekosistem laut tidak hanya akan meningkatkan kesehatan
                        dunia, tetapi juga melindungi sejarah, warisan, dan keindahannya. Dengan selalu menjadi yang terdepan
                        dan mengikuti tren serta teknologi terkini, kami memastikan bahwa kami menyediakan solusi canggih yang
                        tidak hanya mengatasi tantangan saat ini tetapi juga mengantisipasi peluang di masa mendatang.
                    </p>
                </div>

                <!-- Visi -->
                <div class="md:col-span-6 space-y-4 md:pl-8 md:border-l border-gray-800">
                    <h2 class="text-xs uppercase tracking-widest text-[#63CFC0] font-semibold">Arah</h2>
                    <h3 class="text-3xl font-semibold text-white">Visi Kami</h3>
                    <p class="text-gray-400 leading-relaxed text-pretty text-lg">
                        Menjadi platform terdepan dalam menciptakan ekonomi sirkular berbasis kelautan dengan memberdayakan
                        komunitas untuk mengubah sampah laut menjadi produk bernilai dan berkelanjutan.
                    </p>
                </div>
            </section>

            <!-- Misi & Cards -->
            <section class="space-y-12">
                <div class="max-w-2xl">
                    <h2 class="text-xs uppercase tracking-widest text-[#63CFC0] font-semibold mb-4">Tujuan</h2>
                    <h3 class="text-4xl font-semibold text-white mb-6">Misi Kami</h3>
                    <p class="text-gray-400 leading-relaxed text-pretty text-lg">
                        Re:Tide hadir untuk mengedukasi masyarakat tentang pentingnya menjaga ekosistem laut melalui aksi nyata.
                        Kami mengumpulkan sampah plastik dari laut dan mengolahnya menjadi produk berkualitas tinggi yang tidak
                        hanya ramah lingkungan tetapi juga penuh makna.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-neutral-900 border border-gray-800 rounded-2xl p-8 hover:border-[#63CFC0]/50 transition-colors duration-300 group">
                        <div class="w-12 h-12 rounded-full bg-[#63CFC0]/10 flex items-center justify-center mb-6 group-hover:bg-[#63CFC0]/20 transition-colors">
                            <svg class="w-6 h-6 text-[#63CFC0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="text-xl font-medium text-white mb-3">Edukasi</h3>
                        <p class="text-gray-400 leading-relaxed">Meningkatkan kesadaran akan bahayanya pencemaran lautan.</p>
                    </div>
                    
                    <!-- Card 2 -->
                    <div class="bg-neutral-900 border border-gray-800 rounded-2xl p-8 hover:border-[#63CFC0]/50 transition-colors duration-300 group">
                        <div class="w-12 h-12 rounded-full bg-[#63CFC0]/10 flex items-center justify-center mb-6 group-hover:bg-[#63CFC0]/20 transition-colors">
                            <svg class="w-6 h-6 text-[#63CFC0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-xl font-medium text-white mb-3">Pembersihan</h3>
                        <p class="text-gray-400 leading-relaxed">Mengurangi sampah plastik di lautan dengan mengumpulkan dan mengolahnya menjadi produk bernilai.</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-neutral-900 border border-gray-800 rounded-2xl p-8 hover:border-[#63CFC0]/50 transition-colors duration-300 group">
                        <div class="w-12 h-12 rounded-full bg-[#63CFC0]/10 flex items-center justify-center mb-6 group-hover:bg-[#63CFC0]/20 transition-colors">
                            <svg class="w-6 h-6 text-[#63CFC0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-medium text-white mb-3">Partnership</h3>
                        <p class="text-gray-400 leading-relaxed">Kolaborasi dengan pemerintah, non-profit, dan komunitas lokal untuk mencapai tujuan bersama.</p>
                    </div>
                </div>
            </section>

            <!-- Call to Action -->
            <section class="bg-neutral-900 border border-gray-800 rounded-3xl p-12 text-center space-y-8">
                <h2 class="text-3xl md:text-4xl font-semibold text-white">Siapkah Anda untuk menyelamatkan lautan?</h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto">
                    Setiap kontribusi Anda membantu kami memperluas jangkauan dan memperbesar dampak positif pada ekosistem laut.
                </p>
                <div>
                    <a href="/donation" class="inline-block bg-[#63CFC0] hover:bg-[#52B5A7] text-neutral-950 font-medium px-8 py-4 rounded-full transition-colors duration-300">
                        Mulai Berdonasi
                    </a>
                </div>
            </section>

        </main>

        <!-- Footer -->
    <footer class="bg-surface border-t border-border mt-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:flex md:items-center md:justify-between">
            <div class="flex justify-center md:justify-start mb-4 md:mb-0">
                <span class="text-sm text-gray-400">
                    &copy; 2025 <a href="/" class="hover:text-white transition-colors font-semibold">Re:Tide</a>. All Rights Reserved.
                </span>
            </div>
            <ul class="flex justify-center space-x-6 text-sm font-medium text-gray-400">
                <li><a href="/about" class="hover:text-white transition-colors">About Us</a></li>
                <li><a href="/contact" class="hover:text-white transition-colors">Contact</a></li>
                <li><a href="/terms" class="hover:text-white transition-colors">Terms of Service</a></li>
            </ul>
        </div>
    </footer>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #050505;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #222;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #63CFC0;
        }
    </style>
    </div>
</body>

</html>