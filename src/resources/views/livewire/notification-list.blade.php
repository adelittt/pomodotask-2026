<div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8" wire:poll.15s>
    <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-black text-gray-800">Semua Pemberitahuan</h2>
            <p class="text-sm text-gray-500 mt-1">Lihat semua pemberitahuan dan aktivitas terbaru.</p>
        </div>
        <button @click="$dispatch('change-tab', 'home')" class="px-5 py-2.5 bg-white border border-gray-200 shadow-sm text-gray-700 hover:text-red-500 hover:border-red-200 hover:bg-red-50 font-bold rounded-xl text-sm transition-all flex items-center gap-2 self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </button>
    </div>

    <div class="space-y-4">
        @forelse($notifications as $notification)
            <div class="p-5 border border-gray-100 rounded-2xl hover:border-red-100 hover:bg-[#FFF5F6] transition flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 {{ $notification['bg'] }} {{ $notification['color'] }} rounded-full flex items-center justify-center text-xl shadow-sm">
                    {{ $notification['icon'] }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-1 gap-2">
                        <div class="flex items-center gap-2">
                            <h4 class="text-base font-bold text-gray-800">{{ $notification['title'] }}</h4>
                            @if($notification['type'] === 'task')
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-purple-50 text-purple-500 border border-purple-100">Tugas</span>
                            @else
                                <span class="px-2 py-0.5 text-[10px] font-bold rounded-md bg-blue-50 text-blue-500 border border-blue-100">Info Admin</span>
                            @endif
                        </div>
                        <span class="text-xs font-medium text-gray-400 bg-gray-50 px-2 py-1 rounded-lg self-start sm:self-auto shrink-0">{{ \Carbon\Carbon::parse($notification['time'])->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-600 leading-relaxed">{{ $notification['message'] }}</p>
                </div>
            </div>
        @empty
            <div class="py-16 text-center flex flex-col items-center">
                <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                    <span class="text-5xl grayscale opacity-50">📭</span>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">Belum Ada Pemberitahuan</h3>
                <p class="text-sm text-gray-500">Anda belum memiliki pemberitahuan baru saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
