<div class="relative" x-data="{ open: @entangle('isOpen') }" @click.away="open = false" wire:poll.15s>
    <button @click="open = !open" class="w-10 h-10 rounded-full bg-white border border-gray-100 flex items-center justify-center relative shadow-sm text-gray-400 hover:text-red-400 transition focus:outline-none">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
        @if($unreadCount > 0)
            <span class="absolute top-2 right-2.5 w-2.5 h-2.5 bg-red-400 rounded-full border border-white"></span>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] text-center shadow-sm">
                {{ $unreadCount }}
            </span>
        @endif
    </button>

    <div x-show="open" style="display: none; width: 360px;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="absolute right-0 mt-2 bg-white rounded-2xl shadow-lg border border-gray-100 z-50 overflow-hidden">
        
        <div class="px-4 py-3 border-b border-gray-50 flex justify-between items-center bg-gray-50/50">
            <h3 class="text-sm font-bold text-gray-800">Pemberitahuan</h3>
            @if($unreadCount > 0)
                <span class="text-[10px] font-bold text-[#F46B7E] bg-[#FFF5F6] px-2 py-0.5 rounded-full">{{ $unreadCount }} Baru</span>
            @endif
        </div>

        <div class="max-h-[350px] overflow-y-auto main-scroll">
            @forelse($notifications as $notification)
                <div @click="open = false; $dispatch('change-tab', 'notifications')" class="px-4 py-3 border-b border-gray-50 hover:bg-gray-50 transition flex items-start gap-3 cursor-pointer">
                    <div class="flex-shrink-0 w-10 h-10 {{ $notification['bg'] }} {{ $notification['color'] }} rounded-full flex items-center justify-center text-lg shadow-sm">
                        {{ $notification['icon'] }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-bold text-gray-800 mb-0.5 truncate">{{ $notification['title'] }}</h4>
                        <p class="text-xs text-gray-600 leading-snug mb-1 line-clamp-3">{{ $notification['message'] }}</p>
                        <span class="text-[10px] font-medium text-gray-400">{{ \Carbon\Carbon::parse($notification['time'])->diffForHumans() }}</span>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center flex flex-col items-center">
                    <span class="text-3xl mb-2 grayscale opacity-50">📭</span>
                    <p class="text-xs text-gray-500 font-medium">Belum ada pemberitahuan baru.</p>
                </div>
            @endforelse
        </div>
        
        <div class="p-2 border-t border-gray-50 bg-gray-50/50">
            <button @click="open = false; $dispatch('change-tab', 'notifications')" class="w-full text-center text-xs font-bold text-[#F46B7E] py-2 hover:bg-[#FFF5F6] rounded-xl transition">
                Lihat Semua Pemberitahuan
            </button>
        </div>
    </div>
</div>
