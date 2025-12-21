<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Style -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/account.css') }}">
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
    <script src="{{ asset('assets/js/account.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ URL::asset('assets/js/homepage-animation.js') }}"></script>

    <title>Create Blog | Re:Tide</title>
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
        <h1 class="font-semibold text-[#7ae0d3] text-5xl justify-center text-center">Add Blog Post</h1>
        <p class="text-center" style="margin-top: 16px;">Add new blog post!</p>
    </div>

    <!-- Back Button-->
    <!-- <div class="flex justify-center mt-7">
        <button type="button" class="bg-[#7ae0d3] text-black font-semibold py-2 px-4 rounded-full">
            <a href="/blog">Kembali</a>
        </button>
    </div> -->

    @if(session('success'))
        <div class="bg-transparent text-center py-4 lg:px-4">
            <div class="p-2 bg-green-800 items-center text-green-100 leading-none lg:rounded-full flex lg:inline-flex"
                role="alert">
                <span class="flex rounded-full bg-green-300 uppercase px-2 py-1 text-xs font-bold mr-3">Success</span>
                <span class="font-semibold mr-2 text-left flex-auto">Blog post berhasil disimpan!</span>
            </div>
        </div>
    @else
        <div class="bg-transparent text-center py-4 lg:px-4">
            <div class="p-2 bg-red-800 items-center text-red-100 leading-none lg:rounded-full flex lg:inline-flex"
                role="alert">
                <span class="flex rounded-full bg-red-600 uppercase px-2 py-1 text-xs font-bold mr-3">Error</span>
                <span class="font-semibold mr-2 text-left flex-auto">Terjadi kesalahan ketika menyimpan blog post!</span>
            </div>
        </div>
    @endif

    <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto
        space-y-4 mt-6">
        @csrf
        @method('POST')
        <div>
            <label for="title" class="block mb-2.5 text-sm font-medium text-heading">Title</label>
            <input type="text" id="title" name="title"
                class="bg-black border border-default-medium rounded-lg text-heading text-base focus:ring-brand focus:outline-[#7ae0d3] block w-full px-3.5 py-3 placeholder:text-body"
                placeholder="" required />
        </div>
        <div>
            <label for="content" class="block mb-2.5 text-sm font-medium text-heading">Content</label>
            <textarea type="text" id="content" name="content"
                class="bg-black border border-default-medium rounded-lg text-heading text-base focus:ring-brand focus:outline-[#7ae0d3] block w-full px-3.5 py-3 shadow-xs placeholder:text-body"
                placeholder="" required></textarea>
        </div>
        <div>
            <label for="image_path" class="block mb-2.5 text-sm font-medium text-heading">Image</label>
            <input type="file" id="image_path" name="image_path"
                class="bg-black border border-default-medium rounded-lg text-heading text-base focus:ring-brand focus:outline-[#7ae0d3] block w-full px-3.5 py-3 shadow-xs placeholder:text-body"
                placeholder="" />
        </div>

        <button type="button"
            class="text-white bg-red-500 box-border border border-transparent font-medium leading-5 rounded-full text-sm px-4 py-2.5">
            <a href="/blog">Cancel</a></button>
        <button type="submit"
            class="text-black bg-[#7ae0d3] box-border border border-transparent font-medium leading-5 rounded-full text-sm px-4 py-2.5">
            <a href="/blog">Create</a></button>
    </form>

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