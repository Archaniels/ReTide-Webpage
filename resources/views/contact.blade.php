<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Script -->
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    
    <title>Contact</title>
</head>
<body class="defaultTheme">
    <!-- Navigation Bar -->
        <nav class="navbar">
            <ul>
                <li><a href="/">Home</a></li>
                <li><a href="/about">About Us</a></li>
                <li><a href="/blog">Blog</a></li>
                <li><a href="/contact" class="active">Contact</a></li>
                <li><a href="/account">Account</a></li>
                <li><a href="/marketplace">Marketplace</a></li>
                <li><a href="/donation">Donation</a></li>
            </ul>
        </nav>
    
    <div class="contact-container">
        <div class="header">
            <h1>Contact</h1>
        </div>
        <div class="contact-content">
            <p>Email: <span style="font-weight: bolder;"><a href="mailto:contact@retide.com">contact@retide.com</a></span> </p>
            <p>Phone: <span style="font-weight: bolder;">+62 123 4567 7890</span></p>
            <p>Address: <span style="font-weight: bolder;">Telkom University, Bandung, Jawa Barat, Indonesia</span></p>
        </div>
    </div>
</body>
</html>