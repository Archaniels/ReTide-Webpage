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

    <!-- Anime.js -->
    <script src="https://cdn.jsdelivr.net/npm/animejs/dist/bundles/anime.umd.min.js"></script>

    <!-- Flowbite -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@4.0.1/dist/flowbite.min.js"></script>


    <!-- Custom Scripts -->
    <!-- <script src="{{ asset('assets/js/account.js') }}" defer></script> -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ URL::asset('assets/js/homepage-animation.js') }}"></script>

    <title>Edit Blog | Re:Tide</title>
</head>

<body class="defaultTheme">
    <!-- Navbar -->
    <header class="fixed w-full z-20 top-0 start-0">
        <nav class="backdrop-blur-lg">
            <div class="flex flex-wrap justify-center items-center mx-auto max-w-screen-xl p-4">
                <a href="assets/img/ReTide_Logo.png" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="assets/img/ReTide_Logo.png" class="h-7" alt="ReTide Logo" />
                </a>
                <!-- <div class="flex items-center space-x-6 rtl:space-x-reverse">
                    <a href="/login" class="text-sm font-medium text-fg-brand hover:underline">Login</a>
                </div> -->
            </div>
        </nav>
        <nav class="backdrop-blur-lg border-y border-default border-default">
            <div class="max-w-screen-xl px-4 py-3 mx-auto">
                <div class="flex items-center justify-center">
                    <ul class="flex flex-row font-medium mt-0 space-x-8 rtl:space-x-reverse text-sm">
                        <li>
                            <a href="/" class="text-heading hover:underline" aria-current="page">Home</a>
                        </li>
                        <li>
                            <a href="/about" class="text-heading hover:underline">About Us</a>
                        </li>
                        <li>
                            <a href="/blog" class="text-heading hover:underline">Blog</a>
                        </li>
                        <li>
                            <a href="/contact" class="text-heading hover:underline">Contact</a>
                        </li>
                        <li>
                            <a href="/account" class="text-heading hover:underline">Account</a>
                        </li>
                        <li>
                            <a href="/marketplace" class="text-heading hover:underline">Marketplace</a>
                        </li>
                        <li>
                            <a href="/donation" class="text-heading hover:underline">Donation</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div style="margin-top: 150px;">
        <h1 class="font-semibold text-[#7ae0d3] text-5xl justify-center text-center">Blog</h1>
        <p class="text-center" style="margin-top: 16px;">Cerita, berita, dan update terbaru tentang pelestarian laut</p>
    </div>

    <!-- Create Blog Post Button -->
    <div class="justify-center text-center mt-7">
        <a href="{{ route('blog.create') }}" class="btn btn-xs btn-info">✍️ Create Blog Post</a>
    </div>

    <hr style="margin: 3rem 0; border: 1px solid #333;">

    <section class="blog-list">
        <h2 class="section-title font-semibold text-[#7ae0d3] text-4xl justify-center text-center">All Blog Posts</h2>
    </section>

    <section class="blog-post">
        @foreach($blog as $blogPosts)
            <div class="blog-item">
                <img src="{{ asset('storage/' . $blogPosts->image) }}"
                    class="w-full h-64 object-cover border border-[#222] rounded-lg" alt="Blog Image">

                <h3 class="text-2xl font-bold mt-6">{{ $blogPosts->title }}</h3>

                <p class="text-base">{{ $blogPosts->content }}</p>


                <div class="flex bg-[#181818] mt-6 rounded-lg p-3 border border-[#222]">
                    <p class="font-semibold">Created At:</p>
                    <span class="ml-1 italic">{{ $blogPosts->created_at->format('F j, Y, g:i a') }}</span>
                </div>

                <div class="flex bg-[#181818] mt-6 rounded-lg p-3 border border-[#222]">
                    <p class="font-semibold">Updated At:</p>
                    <span class="ml-1 italic">{{ $blogPosts->updated_at->format('F j, Y, g:i a') }}</span>
                </div>

                <div class="flex">
                    <div class="mt-7">
                        <a href="{{ route('blog.edit', $blogPosts->id) }}"
                            class="text-white bg-green-500 box-border border border-transparent font-medium leading-5 rounded-full text-sm px-4 py-2.5">✏️
                            Edit</a>
                    </div>
                    <div class="ml-3 mt-5">
                        <form action="{{ route('blog.destroy', $blogPosts->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-white bg-red-500 box-border border border-transparent font-medium leading-5 rounded-full text-sm px-4 py-2.5"
                                onclick="return confirm('Yakin hapus?')">🗑️
                                Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </section>


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
</body>

</html>