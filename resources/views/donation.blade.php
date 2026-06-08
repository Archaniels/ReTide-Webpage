<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Style -->
  <link rel="stylesheet" href="{{ URL::asset('assets/css/donation.css') }}">
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

  <!-- Script -->
  <script src="{{ asset('assets/js/donation.js') }}" defer></script>
  <style>
    /* Toast Notification (copied from marketplace.css for consistency) */
    .toast-container {
        position: fixed;
        bottom: 24px;
        right: 24px;
        z-index: 1000;
    }
    .toast-message {
        background-color: #63CFC0;
        color: black;
        padding: 12px 24px;
        border-radius: 8px;
        margin-top: 8px;
        font-weight: bold;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        animation: slideIn 0.3s ease, fadeOut 0.5s ease 2.5s forwards;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    @keyframes slideIn {
        from { transform: translateX(100%); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
  </style>
  <script>
    function showToast(message) {
        if ($(".toast-container").length === 0) {
            $("body").append('<div class="toast-container"></div>');
        }
        const toast = $(`
            <div class="toast-message">
                <i class="fas fa-check-circle"></i>
                <span>${message}</span>
            </div>
        `);
        $(".toast-container").append(toast);
        setTimeout(() => { toast.remove(); }, 3000);
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showToast("{{ session('success') }}");
        @endif
        @if(session('error'))
            showToast("{{ session('error') }}");
        @endif
    });
  </script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="{{ URL::asset('assets/js/homepage-animation.js') }}"></script>

  <title>Donation</title>
</head>

<body class="defaultTheme">
  <div class="donation-page">
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
  </div>

  <div class="donation-layout">
    <div class="donation-hero">
      <h1 class="hero-title">Bantu Kami Melindungi Lautan</h1>
      <p class="hero-subtitle">Setiap kontribusi Anda menjadi langkah nyata dalam memulihkan ekosistem dan mendukung komunitas pesisir.</p>
      
      <div class="total-donations-widget">
        <h3 class="widget-title">Total Donasi Terkumpul</h3>
        <p class="widget-amount">Rp {{ number_format($totalDonations, 0, ',', '.') }}</p>
        <div class="widget-bar">
           <div class="widget-progress" style="width: 75%;"></div>
        </div>
        <p class="widget-caption">Bersama kita bisa mencapai lebih banyak.</p>
      </div>
    </div>

    <div class="donation-sidebar">
      <section class="donation-form-section">
        <h2 class="form-title">Pilih Nominal Donasi</h2>
        
        <form method="POST" action="{{ route('donation.store') }}" class="donation-form" id="donationForm">
            @csrf

            <div class="amount-presets">
                <button type="button" class="preset-btn" data-amount="25000">Rp 25.000</button>
                <button type="button" class="preset-btn" data-amount="50000">Rp 50.000</button>
                <button type="button" class="preset-btn" data-amount="100000">Rp 100.000</button>
                <button type="button" class="preset-btn active" data-amount="custom">Lainnya</button>
            </div>

            <div class="input-group" id="custom-amount-wrapper">
                <label class="input-label">Nominal (Rp)</label>
                <input type="number" id="amount-input" name="amount" min="1000" class="input-style" placeholder="Masukkan nominal">
            </div>

            <div class="input-group">
                <label class="input-label">Nama Lengkap</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}" class="input-style" readonly>
            </div>

            <div class="input-group">
                <label class="input-label">Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}" class="input-style" readonly>
            </div>

            <div class="input-group">
                <label class="input-label">Pesan atau Dukungan (Opsional)</label>
                <textarea name="message" rows="3" class="input-style" placeholder="Tulis harapan Anda..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
              Donasi Sekarang
            </button>
        </form>
      </section>
    </div>
  </div>

  <section class="donation-feed-section">
      <h2 class="feed-title">Kontributor Terbaru</h2>
      <div class="donation-feed">
        @forelse ($donations as $donation)
          <div class="feed-item-wrapper">
            <div class="feed-item">
              <div class="feed-avatar">
                {{ strtoupper(substr($donation->name ?? 'A', 0, 1)) }}
              </div>
              <div class="feed-content">
                <div class="feed-header">
                  <span class="feed-name">{{ $donation->name ?? 'Anonim' }}</span>
                  <span class="feed-amount">Rp {{ number_format($donation->amount, 0, ',', '.') }}</span>
                </div>
                @if($donation->message)
                  <p class="feed-message">"{{ $donation->message }}"</p>
                @endif
                <div class="feed-meta">
                  <span class="feed-date">{{ $donation->created_at->diffForHumans() }}</span>
                  <button class="toggle-timeline-link" data-donation-id="{{ $donation->id }}">Lihat Perjalanan</button>
                </div>
              </div>
            </div>
            <div class="timeline-container" id="timeline-{{ $donation->id }}" style="display:none;">
              <div class="timeline-content">
                <!-- Updates will be loaded here -->
              </div>
            </div>
          </div>
        @empty
          <p class="empty-donation">Belum ada donasi.</p>
        @endforelse
      </div>
  </section>

  {{-- ================= TIMELINE DONASI (USER) - Per donasi ================= --}}

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
    // Toggle timeline for each donation
    $(document).ready(function() {
      $('.toggle-timeline-link').click(function() {
        var donationId = $(this).data('donation-id');
        var timelineRow = $('#timeline-' + donationId);
        var timelineContent = timelineRow.find('.timeline-content');

        if (timelineRow.is(':visible')) {
          timelineRow.hide();
        } else {
          loadTimeline(donationId);
          timelineRow.show();
        }
      });

      // Auto update visible timelines every 30 seconds
      setInterval(function() {
        $('.timeline-container:visible').each(function() {
          var donationId = $(this).attr('id').replace('timeline-', '');
          loadTimeline(donationId);
        });
      }, 30000);
    });

    function loadTimeline(donationId) {
      var timelineContent = $('#timeline-' + donationId).find('.timeline-content');

      $.ajax({
        url: '/donation/' + donationId + '/updates',
        type: 'GET',
        success: function(data) {
          if (data.length > 0) {
            var html = '<div class="timeline">';
            data.forEach(function(update) {
              html += `
                <div class="timeline-item">
                  <div class="timeline-dot"></div>
                  <div class="timeline-content">
                    <h4>${update.title}</h4>
                    <p>${update.description}</p>
                    <span class="timeline-date">${new Date(update.created_at).toLocaleString('id-ID')}</span>
                  </div>
                </div>
              `;
            });
            html += '</div>';
            timelineContent.html(html);
          } else {
            timelineContent.html('<p class="text-gray-300">Belum ada update untuk donasi ini.</p>');
          }
        },
        error: function() {
          timelineContent.html('<p class="text-red-300">Error loading updates.</p>');
        }
      });
    }
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preset Buttons Logic
        const presetBtns = document.querySelectorAll('.preset-btn');
        const amountInput = document.getElementById('amount-input');
        const customWrapper = document.getElementById('custom-amount-wrapper');

        presetBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                presetBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const val = this.getAttribute('data-amount');
                if (val === 'custom') {
                    customWrapper.style.display = 'block';
                    amountInput.value = '';
                    amountInput.focus();
                } else {
                    customWrapper.style.display = 'none';
                    amountInput.value = val;
                }
            });
        });

        // Validation Form Logic
        const form = document.querySelector('form.donation-form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const amountStr = form.querySelector('input[name="amount"]').value;
                const name = form.querySelector('input[name="name"]').value;
                const email = form.querySelector('input[name="email"]').value;
                
                let errors = [];
                
                if (!amountStr || amountStr.trim() === '' || !name || name.trim() === '' || !email || email.trim() === '') {
                    errors.push('All fields are required');
                } else {
                    if (amountStr && amountStr.trim() !== '') {
                        if (/[a-zA-Z]/.test(amountStr)) {
                            errors.push('Please enter a valid numeric amount.');
                        } else if (/[^\d.\-]/.test(amountStr)) {
                            errors.push('Numeric values only.');
                        } else {
                            const amount = parseFloat(amountStr);
                            if (isNaN(amount)) {
                                errors.push('Please enter a valid numeric amount.');
                            } else if (amount <= 0) {
                                errors.push('Donation amount must be greater than 0.');
                            } else if (amount < 1000) {
                                errors.push('Minimum donation amount is Rp 1000.');
                            }
                        }
                    }

                    if (errors.length === 0 && name && name.trim() !== '') {
                        if (name.length < 2) {
                            errors.push('Name must be at least 2 characters long.');
                        } else if (name.length > 50) {
                            errors.push('Name cannot exceed 50 characters.');
                        } else if (/[0-9]/.test(name)) {
                            errors.push('Name can only contain alphabetic characters.');
                        } else if (/[^a-zA-Z\s\-]/.test(name)) {
                            errors.push('Name contains invalid characters.');
                        }
                    }

                    if (errors.length === 0 && email && email.trim() !== '') {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(email)) {
                            errors.push('Please enter a valid email address.');
                        }
                    }
                }

                if (errors.length > 0) {
                    e.preventDefault();
                    if (typeof showToast === 'function') {
                        showToast(errors[0]);
                    }
                }
            });
        }
    });
  </script>
</body>

</html>