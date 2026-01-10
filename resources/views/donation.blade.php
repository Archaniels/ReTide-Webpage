<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

  <div class="donation-container" style="margin-top: 120px;">
    <div class="header">
      <h1 class="font-semibold text-[#7ae0d3]">Donation</h1>
      <p>Berikan kontribusi Anda untuk mendukung kegiatan konservasi laut kami.</p>
      <div class="total-donations mt-4 p-4 bg-blue-900 rounded-lg">
        <h3 class="text-white text-lg font-semibold">Total Donasi Terkumpul</h3>
        <p class="text-[#7ae0d3] text-2xl font-bold">Rp {{ number_format($totalDonations, 0, ',', '.') }}</p>
      </div>
    </div>

    <section class="donation-form-section">
    
      <!-- ADMIN DONATION MANAGEMENT SECTION -->
      @if(auth()->check() && auth()->user()->role === 'admin')
        <div class="mb-8 p-6 bg-blue-900 rounded-lg border-l-4 border-blue-400">
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-2xl font-semibold text-white mb-2">
                  Kelola Donasi
              </h2>
              <p class="text-gray-300">Sebagai admin, Anda bisa kelola semua data donasi</p>
            </div>
            <a href="{{ route('admin.donations.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition">
              → Dashboard Admin
            </a>
          </div>
        </div>
      @endif
      
      <!-- JUDUL FORM -->
      <h2 class="text-xl font-semibold text-white mb-6">
          Formulir Donasi
      </h2>

      <form method="POST" action="{{ route('donation.store') }}" class="donation-form">
          @csrf

          <div class="mb-4">
              <label class="block text-sm text-gray-300 mb-2">
                  Nama Lengkap
              </label>
              <input type="text" name="name" value="{{ auth()->user()->name }}" class="w-full input-style" readonly>
          </div>

          <div class="mb-4">
              <label class="block text-sm text-gray-300 mb-2">
                  Email
              </label>
              <input type="email" name="email" value="{{ auth()->user()->email }}" class="w-full input-style" readonly>
          </div>

          <div class="mb-4">
              <label class="block text-sm text-gray-300 mb-2">
                  Nominal Donasi (Rp)
              </label>
              <input type="number" name="amount" min="1000" class="w-full input-style">
          </div>

          <div class="mb-6">
              <label class="block text-sm text-gray-300 mb-2">
                  Pesan atau Dukungan
              </label>
              <textarea name="message" rows="3" class="w-full input-style"
                  placeholder="Tulis pesan Anda..."></textarea>
          </div>

          <button type="submit" class="btn btn-primary">
            Simpan Donasi
          </button>
      </form>

    </section>

    <section class="donation-list-section">
      <h2 class="section-title">Daftar Donasi</h2>

      @forelse ($donations as $donation)
        <div class="donation-card">
          <div class="donation-header">
            <h3 class="donor-name">{{ $donation->name ?? 'Anonim' }}</h3>
            <span class="donation-date">
              {{ $donation->created_at->format('d M Y H:i') }}
            </span>
          </div>

          <div class="donation-body">
            <p><span>Email:</span> {{ $donation->email ?? '-' }}</p>
            <p class="donation-amount">
              Rp {{ number_format($donation->amount, 0, ',', '.') }}
            </p>
            <p class="donation-message">
              {{ $donation->message ?? 'Tanpa pesan' }}
            </p>
            <button class="toggle-timeline mt-4 bg-blue-500 text-white px-4 py-2 rounded" data-donation-id="{{ $donation->id }}">
              Lihat Perjalanan Donasi
            </button>

            <!-- Admin Action Buttons -->
            @if(auth()->check() && auth()->user()->role === 'admin')
              <div class="flex gap-2 mt-4">
                <a href="{{ route('admin.donations.edit', $donation->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                  ✏️ Edit
                </a>
                <a href="{{ route('admin.donations.updates.create', $donation->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">
                  📝 Tambah Update
                </a>
                <form method="POST" action="{{ route('admin.donations.destroy', $donation->id) }}" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" onclick="return confirm('Yakin hapus?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                    🗑️ Hapus
                  </button>
                </form>
              </div>
            @endif
          </div>

          <div class="timeline-container mt-4" id="timeline-{{ $donation->id }}" style="display:none;">
            <h4 class="text-white">Perjalanan Donasi</h4>
            <div class="timeline-content">
              <!-- Updates will be loaded here -->
            </div>
          </div>
        </div>
      @empty
        <p class="empty-donation">Belum ada donasi.</p>
      @endforelse
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
      $('.toggle-timeline').click(function() {
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
        url: 'http://localhost:3000/donation-updates/' + donationId,
        type: 'GET',
        success: function(data) {
          console.log('Timeline data received:', data);
          if (data && data.length > 0) {
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
        error: function(xhr, status, error) {
          console.error('Error loading timeline:', error);
          timelineContent.html('<p class="text-red-300">Error loading updates: ' + error + '</p>');
        }
      });
    }
  </script>
</body>

</html>