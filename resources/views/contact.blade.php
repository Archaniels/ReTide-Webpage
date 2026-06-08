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
    <!-- Script -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ URL::asset('assets/js/homepage-animation.js') }}"></script>

    <title>Contact</title>
</head>

<body class="defaultTheme">
    <div style="width: 100%; height: 100px;"><img src="assets/img/TopDecoration.png" alt="ReTide Logo"></div>

    <div class="smoothen-gradient-box" style="margin-top: -248px;"></div>

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
                        <li><a href="/contact" class="text-[#63cfc0] hover:text-white transition-colors">Contact</a></li>
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
    <main class="pt-32 pb-24 px-4 sm:px-6 lg:px-8 max-w-screen-xl mx-auto">
        <div class="max-w-6xl mx-auto bg-neutral-900 border border-gray-800 rounded-3xl overflow-hidden shadow-2xl">
            <div class="grid grid-cols-1 lg:grid-cols-2">
                
                <!-- Left: Contact Info -->
                <div class="p-10 lg:p-16 space-y-12">
                    <div class="space-y-4">
                        <h1 class="text-4xl md:text-5xl font-bold text-white tracking-tight">Get in Touch</h1>
                        <p class="text-gray-400 text-lg leading-relaxed text-pretty">
                            Apakah Anda memiliki pertanyaan, ide kolaborasi, atau ingin berpartisipasi dalam program kami? Kami ingin mendengar dari Anda.
                        </p>
                    </div>
                    
                    <div class="space-y-8">
                        <!-- Email -->
                        <div class="flex items-start gap-4 group cursor-pointer">
                            <div class="w-12 h-12 rounded-full bg-[#63CFC0]/10 flex items-center justify-center shrink-0 group-hover:bg-[#63CFC0]/20 transition-colors">
                                <svg class="w-6 h-6 text-[#63CFC0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm uppercase tracking-wider font-semibold text-gray-500 mb-1">Email</h3>
                                <a href="mailto:contact@retide.com" class="text-lg font-medium text-white group-hover:text-[#63CFC0] transition-colors">contact@retide.com</a>
                            </div>
                        </div>
                        
                        <!-- Phone -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#63CFC0]/10 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-[#63CFC0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm uppercase tracking-wider font-semibold text-gray-500 mb-1">Phone</h3>
                                <p class="text-lg font-medium text-white">+62 123 4567 7890</p>
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-full bg-[#63CFC0]/10 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6 text-[#63CFC0]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm uppercase tracking-wider font-semibold text-gray-500 mb-1">Address</h3>
                                <p class="text-lg font-medium text-white max-w-xs text-balance">Telkom University, Bandung, Jawa Barat, Indonesia</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Contact Form -->
                <div class="p-10 lg:p-16 bg-neutral-950 border-t lg:border-t-0 lg:border-l border-gray-800 flex flex-col justify-center">
                    <form action="#" method="POST" class="space-y-6">
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-gray-300">Full Name</label>
                            <input type="text" id="name" name="name" placeholder="John Doe" class="w-full bg-neutral-900 border border-gray-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-[#63CFC0] focus:border-transparent transition-all">
                        </div>
                        
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-gray-300">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="john@example.com" class="w-full bg-neutral-900 border border-gray-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-[#63CFC0] focus:border-transparent transition-all">
                        </div>

                        <div class="space-y-2">
                            <label for="message" class="block text-sm font-medium text-gray-300">Your Message</label>
                            <textarea id="message" name="message" rows="4" placeholder="How can we help you?" class="w-full bg-neutral-900 border border-gray-700 rounded-xl px-4 py-3 text-white placeholder-gray-600 focus:outline-none focus:ring-2 focus:ring-[#63CFC0] focus:border-transparent transition-all resize-none"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-[#63CFC0] hover:bg-[#52B5A7] text-neutral-950 font-medium px-8 py-4 rounded-xl transition-colors duration-300 mt-4">
                            Send Message
                        </button>
                    </form>
                </div>

            </div>
        </div>
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
</body>

</html>