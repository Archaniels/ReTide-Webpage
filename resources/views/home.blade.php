<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Script -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('assets/js/homepage-animation.js') }}"></script>

    <!-- Tailwind CSS Experimental Implementation-->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Lenis by Darkroom Engineering -->
    <script src="https://unpkg.com/lenis@1.3.14/dist/lenis.min.js"></script>

    <!-- GSAP + ScrollTrigger -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- Anime.js -->
    <script src="https://cdn.jsdelivr.net/npm/animejs/dist/bundles/anime.umd.min.js"></script>

    <title>ReTide</title>
</head>

<body class="defaultTheme homepage">
    <!-- 🌐 Navigation Bar -->
    <nav class="navbar" style="padding-top: 80px;">
        <ul>
            <li><a href="/" class="active">Home</a></li>
            <li><a href="/about">About Us</a></li>
            <li><a href="/blog">Blog</a></li>
            <li><a href="/contact">Contact</a></li>
            <li><a href="/account">Account</a></li>
            <li><a href="/marketplace">Marketplace</a></li>
            <li><a href="/donation">Donation</a></li>
        </ul>
    </nav>

    <!-- 🌟 Text on top of background -->
    <div class="hero-text">
            <h1>Welcome to ReTide</h1>
            <p>Ride the wave of sustainability and innovation.</p>
            <a href="/about" class="cta-button">Learn More</a>
        </div>

        <div class="smoothen-gradient-box"></div>

        <div style="text-align: center; margin-top: 150px;">
            <img src="{{ asset('assets/img/Stats.png') }}" style="max-width: 60rem; height: auto;">
        </div>

        <!--
        <div class="visi-misi">
            <img src="{{ asset('assets/img/Rectangle 40.png') }}"
                style="max-width: 500px; height: auto; margin-top: 64px; margin-left: 720px; padding-bottom: 300px;">
        </div>


        <div class="homepage-container-boxes"></div>
        <div class="homepage-container-boxes" style="left: -32px"></div>
        -->

        <!-- Visi -->
        <section class="about-section" style="margin-left: 256px;">
            <h2 class="section-title">Visi Kami</h2>
            <p class="section-subtitle">
                Menjadi platform terdepan dalam menciptakan ekonomi sirkular berbasis kelautan dengan memberdayakan komunitas untuk mengubah sampah laut menjadi produk bernilai dan berkelanjutan.
            </p>
        </section>

        <!-- Misi Kami -->
        <section class="about-section" style="margin-left: 256px;">
            <h2 class="section-title">Misi Kami</h2>
            <p class="section-subtitle">
                Re:Tide hadir untuk mengedukasi masyarakat tentang pentingnya menjaga ekosistem laut melalui aksi nyata. Kami mengumpulkan sampah plastik dari laut dan mengolahnya menjadi produk berkualitas tinggi yang tidak hanya ramah lingkungan tetapi juga penuh makna.
            </p>
        </section>

        <!-- Call to Action -->
        <section class="about-section about-cta" style="justify-self: center; padding-top: 64px;">
            <a href="/donation" class="cta-button">Siapkah Anda untuk menyelamatkan lautan?</a>
        </section>
    </div>
</body>
</html>