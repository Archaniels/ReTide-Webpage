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


    <div class="contact-container" style="margin-top: 8rem; margin-bottom: 9rem;">
        <div class="header">
            <h1 class="font-semibold text-[#7ae0d3]">Contact</h1>
        </div>
        <div class="contact-content">
            <p>Email: <span style="font-weight: bolder;"><a
                        href="mailto:contact@retide.com">contact@retide.com</a></span> </p>
            <p>Phone: <span style="font-weight: bolder;">+62 123 4567 7890</span></p>
            <p>Address: <span style="font-weight: bolder;">Telkom University, Bandung, Jawa Barat, Indonesia</span></p>
        </div>
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
</body>

</html>