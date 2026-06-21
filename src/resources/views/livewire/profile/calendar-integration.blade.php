<div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
    <h3 class="text-lg font-bold text-gray-800 mb-4">Integrasi Kalender</h3>
    
    @if (session()->has('message'))
        <div class="mb-4 p-3 bg-green-50 text-green-700 rounded-lg text-sm">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-semibold text-gray-700">Google Calendar</h4>
                <p class="text-sm text-gray-500">
                    {{ $isConnected ? 'Terhubung' : 'Belum Terhubung' }}
                </p>
            </div>
        </div>

        @if ($isConnected)
            <button wire:click="disconnect" class="px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                Putuskan
            </button>
        @else
            <button wire:click="connect" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                Hubungkan
            </button>
        @endif
    </div>
</div>
