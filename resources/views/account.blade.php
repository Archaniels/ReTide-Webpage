<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('assets/css/account.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="{{ asset('assets/js/account.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <title>Account</title>
</head>

<body class="defaultTheme">
    <div class="account-page">
        <!-- 🌐 Navigation Bar -->
        <nav class="navbar">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About Us</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/contact">Contact</a></li>
                <li><a href="/account" class="active">Account</a></li>
                <li><a href="/marketplace">Marketplace</a></li>
                <li><a href="/donation">Donation</a></li>
            </ul>
        </nav>
    </div>

    <div class="account-container">
        <div class="header">
            <h1>Account</h1>
            <p>Pengaturan akun, profil, dan preferensi Anda.</p>
        </div>

        <section class="account-settings">
            <h2 class="section-title">Account Settings</h2>
            <form class="account-form" action="#" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="notelp">No Telp:</label>
                <input type="text" id="notelp" name="notelp">

                <button type="#" class="btn">Update Settings</button>
            </form>
            <button id="delete-btn" class="btn delete-btn">Delete Account</button>
        </section>
    </div>
</body>

</html>