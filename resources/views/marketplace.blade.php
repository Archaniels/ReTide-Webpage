<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Style -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/css/marketplace.css') }}">
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Script -->
    <script src="{{ asset('assets/js/marketplace.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ URL::asset('assets/js/homepage-animation.js') }}"></script>

    <title>Marketplace</title>
</head>

<body class="defaultTheme">
    <div style="width: 100%; height: 100px;"><img src="assets/img/TopDecoration.png" alt="ReTide Logo"></div>

    <div class="smoothen-gradient-box" style="margin-top: -248px;"></div>

    <div class="marketplace-page">
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
                            <li><a href="/about" class="text-gray-300 hover:text-white transition-colors">About</a></li>
                            <li><a href="/contact" class="text-gray-300 hover:text-white transition-colors">Contact</a></li>
                            <li><a href="/account" class="text-gray-300 hover:text-white transition-colors">Account</a></li>
                            <li><a href="/blog" class="text-gray-300 hover:text-white transition-colors">Blog</a></li>
                            <li><a href="/marketplace" class="text-[#63cfc0] hover:text-white transition-colors">Marketplace</a></li>
                            <li><a href="/donation" class="text-gray-300 hover:text-white transition-colors">Donation</a></li>
                        </ul>
                    </nav>
                    <div class="flex items-center space-x-4">
                        <a href="/account" class="hidden md:block text-gray-300 hover:text-white transition-colors">
                            <i class="fas fa-user-circle text-xl"></i>
                        </a>
                        <button id="mobile-menu-btn" class="md:hidden text-gray-300 hover:text-white focus:outline-none p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden bg-[#121212] border-b border-white/5 absolute w-full transition-all duration-300">
                <ul class="px-4 pt-2 pb-6 space-y-4 text-sm font-medium">
                    <li><a href="/" class="block text-gray-300 hover:text-white transition-colors">Home</a></li>
                    <li><a href="/about" class="block text-gray-300 hover:text-white transition-colors">About</a></li>
                    <li><a href="/contact" class="block text-gray-300 hover:text-white transition-colors">Contact</a></li>
                    <li><a href="/account" class="block text-gray-300 hover:text-white transition-colors">Account</a></li>
                    <li><a href="/blog" class="block text-gray-300 hover:text-white transition-colors">Blog</a></li>
                    <li><a href="/marketplace" class="block text-[#63cfc0] hover:text-white transition-colors">Marketplace</a></li>
                    <li><a href="/donation" class="block text-gray-300 hover:text-white transition-colors">Donation</a></li>
                </ul>
            </div>
        </header>

        <!-- Header -->
        <div class="marketplace-container" style="margin-top: 60px;">
            <div class="header">
                <h1 class="font-semibold text-[#7ae0d3]">Marketplace</h1>
                <p>Produk ramah lingkungan dari sampah laut yang didaur ulang</p>
            </div>

            <!-- Cart Button -->
            <div class="cart-toggle" style="margin-top: 120px;">
                <button id="cart-btn" class="btn cart-btn">
                    Keranjang (<span id="cart-count">0</span>)
                </button>
            </div>

            <!-- Products Grid -->
            <section class="products-section">
                <h2 class="section-title">Produk Kami</h2>
                <div class="products-grid" id="products-grid">
                    <!-- Products akan di-render oleh JavaScript -->
                </div>
            </section>

            <!-- Shopping Cart -->
            <section class="cart-section" id="cart-section" style="display: none;">
                <div class="cart-header">
                    <h2 class="section-title">Keranjang Belanja</h2>
                    <button id="close-cart" class="btn-close">✕</button>
                </div>
                <div class="cart-items" id="cart-items">
                    <!-- Cart items akan di-render oleh JavaScript -->
                </div>
                <div class="cart-footer">
                    <div class="cart-total">
                        <h3>Total: Rp <span id="total-price">0</span></h3>
                    </div>
                    <button class="btn checkout-btn">Checkout</button>
                    <button class="btn delete-btn clear-cart-btn" id="clear-cart">Kosongkan Keranjang</button>
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="bg-neutral-primary-soft border border-default m-4 rounded-xl border-gray-900">
            <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
                <span class="text-sm text-body sm:text-center">© 2025 <a href="http://127.0.0.1:8001/"
                        class="hover:underline">Re:Tide</a>. All Rights Reserved.
                </span>
                <ul class="flex flex-wrap items-center mt-3 text-sm font-medium text-body sm:mt-0">
                    <li>
                        <a href="/about" class="hover:underline me-4 md:me-6">About</a>
                    </li>
                    <li>
                        <a href="/contact" class="hover:underline">Contact</a>
                    </li>
                </ul>
            </div>
        </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const btn = document.getElementById('mobile-menu-btn');
            const menu = document.getElementById('mobile-menu');
            if(btn && menu) {
                btn.addEventListener('click', () => {
                    menu.classList.toggle('hidden');
                });
            }
        });
    </script>
    </div>
</body>

</html>