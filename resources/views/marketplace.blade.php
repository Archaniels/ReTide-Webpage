<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/marketplace.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Script -->
    <script src="{{ asset('assets/js/marketplace.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <title>Marketplace</title>
</head>

<body class="defaultTheme">
    <div class="marketplace-page">
        <!-- 🌐 Navigation Bar -->
        <nav class="navbar">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About Us</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/account">Account</a></li>
                <li><a href="/marketplace" class="active">Marketplace</a></li>
                <li><a href="/donation">Donation</a></li>
            </ul>
        </nav>

        <!-- Header -->
        <div class="marketplace-container">
            <div class="header">
                <h1>Marketplace</h1>
                <p>Produk ramah lingkungan dari sampah laut yang didaur ulang</p>
            </div>

            <!-- Cart Button -->
            <div class="cart-toggle">
                <button id="cart-btn" class="btn cart-btn">
                    🛒 Keranjang (<span id="cart-count">0</span>)
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
    </div>
</body>

</html>