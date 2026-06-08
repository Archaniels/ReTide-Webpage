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

    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>

    <!-- Custom Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ URL::asset('assets/js/homepage-animation.js') }}"></script>

    <title>Blog | Re:Tide</title>
</head>

<body class="bg-[#121212] text-gray-100 font-['Poppins']">
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
                        <li><a href="/blog" class="text-gray-300 hover:text-white transition-colors">Blog</a></li>
                        <li><a href="/marketplace" class="text-brand transition-colors">Marketplace</a></li>
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

    <div class="pt-[160px] pb-16 max-w-screen-xl mx-auto px-4">
        <h1 class="font-bold text-[#63CFC0] text-5xl md:text-6xl text-center tracking-tight">Our Blog</h1>
        <p class="text-center text-gray-400 mt-6 text-lg max-w-2xl mx-auto">Stories, news, and the latest updates about ocean conservation and our journey towards a sustainable circular economy.</p>
    </div>

    <section class="pb-24 px-4 max-w-screen-xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($blog as $blogPosts)
                <a href="{{ route('blog.show', $blogPosts->id) }}" class="group block h-full flex flex-col bg-[#1E1E1E] border border-[#2A2A2A] rounded-2xl overflow-hidden hover:border-[#63CFC0] transition-all duration-300 hover:shadow-[0_0_20px_rgba(99,207,192,0.1)]">
                    <div class="relative h-56 overflow-hidden bg-[#121212]">
                        <img src="{{ asset('storage/' . $blogPosts->image_path) }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Blog Image">
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-2xl font-semibold text-white mb-3 line-clamp-2 group-hover:text-[#63CFC0] transition-colors">{{ $blogPosts->title }}</h3>
                        <p class="text-gray-400 text-sm mb-6 line-clamp-3 flex-grow leading-relaxed">{{ $blogPosts->content }}</p>
                        <div class="flex items-center text-xs text-gray-500 mt-auto pt-4 border-t border-[#2A2A2A]">
                            @if($blogPosts->created_at)
                                <span>{{ $blogPosts->created_at->format('F j, Y') }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
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
