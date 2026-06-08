<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

    <title>ReTide</title>
</head>

<body class="defaultTheme hide-scrollbar">
    <div class="homepage" style="height: 110vh; padding-top: 0px;">
    </div>

    <!-- Navbar -->
    <header class="fixed w-full z-50 top-0 start-0 border-b border-white/5 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center">
                        <img src="{{ asset('assets/img/ReTide_Logo.png') }}" class="h-8" alt="ReTide Logo" />
                    </a>
                </div>
                <nav class="hidden md:block">
                    <ul class="flex space-x-8 text-sm font-medium">
                        <li><a href="/" class="text-[#63cfc0] hover:text-white transition-colors">Home</a></li>
                        <li><a href="/about" class="text-gray-300 hover:text-white transition-colors">About</a></li>
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


    <!-- 🌟 Text on top of background -->
    <div class="hero-text">
        <h1>Welcome to ReTide</h1>
        <p>Ride the wave of sustainability and innovation.</p>
        <a href="/about" class="cta-button">Learn More</a>
    </div>

    <div class="smoothen-gradient-box" style="margin-top: 20rem;"></div>

    <div style="text-align: center; margin-top: 10rem; padding: 0 1rem;">
        <img src="{{ asset('assets/img/Stats.png') }}"
            style="max-width: 60rem; width: 100%; height: auto; margin: 0 auto;">
    </div>

    <!-- Visi -->
    <section class="about-section">
        <h2 class="section-title">Visi Kami</h2>
        <p class="section-subtitle">
            Menjadi platform terdepan dalam menciptakan ekonomi sirkular berbasis kelautan dengan memberdayakan
            komunitas untuk mengubah sampah laut menjadi produk bernilai dan berkelanjutan.
        </p>
    </section>

    <!-- Misi Kami -->
    <section class="about-section">
        <h2 class="section-title">Misi Kami</h2>
        <p class="section-subtitle">
            Re:Tide hadir untuk mengedukasi masyarakat tentang pentingnya menjaga ekosistem laut melalui aksi nyata.
            Kami mengumpulkan sampah plastik dari laut dan mengolahnya menjadi produk berkualitas tinggi yang tidak
            hanya ramah lingkungan tetapi juga penuh makna.
        </p>
    </section>

    <!-- Call to Action -->
    <section class="about-section about-cta" style="padding-top: 64px;">
        <a href="/donation" class="cta-button">Siapkah Anda untuk menyelamatkan lautan?</a>
    </section>

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

</body>

</html>