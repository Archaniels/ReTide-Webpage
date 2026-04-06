@forelse ($updates as $update)
    <div class="update-item relative pl-8 pb-8 last:pb-0">
        <!-- Timeline Line -->
        <div class="absolute left-[11px] top-0 bottom-0 w-0.5 bg-gray-800"></div>
        <!-- Timeline Point -->
        <div class="absolute left-0 top-1.5 w-6 h-6 rounded-full bg-dark border-2 border-primary z-10 flex items-center justify-center">
            <div class="w-2 h-2 rounded-full bg-primary shadow-[0_0_8px_rgba(99,207,192,0.6)]"></div>
        </div>

        <div class="bg-dark-lighter/50 border border-gray-800 rounded-xl p-5 shadow-sm hover:border-gray-700 transition-colors">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-2 mb-3">
                <h4 class="text-white font-bold text-lg leading-tight">{{ $update['title'] }}</h4>
                <div class="flex items-center space-x-3">
                    @php
                        $status = strtolower($update['status']);
                        $statusClass = match($status) {
                            'proses' => 'bg-orange-500/10 text-orange-400 border-orange-500/20',
                            'tersalurkan' => 'bg-green-500/10 text-green-400 border-green-500/20',
                            'selesai' => 'bg-primary/10 text-primary border-primary/20',
                            default => 'bg-gray-500/10 text-gray-400 border-gray-500/20',
                        };
                    @endphp
                    <span class="px-2.5 py-0.5 rounded-full border text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
                        {{ $status }}
                    </span>
                    <span class="text-secondary text-xs opacity-60">
                        <i class="far fa-clock mr-1"></i>
                        {{ \Carbon\Carbon::parse($update['created_at'])->format('d M Y, H:i') }}
                    </span>
                </div>
            </div>
            <p class="text-secondary text-sm leading-relaxed whitespace-pre-line">{{ $update['description'] }}</p>
        </div>
    </div>
@empty
    <div class="text-center py-8 text-secondary italic">
        <i class="fas fa-info-circle mr-2"></i> No updates recorded for this donation yet.
    </div>
@endforelse