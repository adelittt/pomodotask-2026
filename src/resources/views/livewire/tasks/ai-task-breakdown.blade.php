<div class="bg-gradient-to-br from-indigo-50 to-purple-50 p-6 rounded-2xl border border-indigo-100 shadow-sm mt-6">
    <div class="flex items-center gap-3 mb-4">
        <span class="text-2xl">✨</span>
        <h3 class="text-lg font-bold text-indigo-900">AI Task Breakdown</h3>
    </div>
    
    <p class="text-sm text-indigo-700 mb-4">
        Bingung mulai dari mana? Biarkan Gemini AI memecah tugas besar Anda menjadi langkah-langkah kecil yang lebih mudah dikerjakan.
    </p>

    <div class="flex gap-2">
        <input wire:model="taskTitle" type="text" placeholder="Contoh: Buat website portofolio..." 
            class="flex-1 px-4 py-2 rounded-xl border border-indigo-200 focus:border-indigo-400 focus:ring focus:ring-indigo-200 outline-none transition text-gray-700">
        
        <button wire:click="generateBreakdown" wire:loading.attr="disabled"
            class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition disabled:opacity-50 flex items-center gap-2">
            <span wire:loading.remove>Generate</span>
            <span wire:loading>
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </span>
        </button>
    </div>

    @if ($errorMessage)
        <p class="text-sm text-red-500 mt-3 font-medium">{{ $errorMessage }}</p>
    @endif

    @if (!empty($subtasks))
        <div class="mt-5">
            <h4 class="text-sm font-semibold text-indigo-800 mb-3">Saran Subtugas:</h4>
            <div class="space-y-2 max-h-60 overflow-y-auto pr-2 custom-scrollbar">
                @foreach ($subtasks as $index => $subtask)
                    <div class="flex items-start gap-3 p-3 bg-white rounded-lg border border-indigo-100 hover:border-indigo-300 transition group">
                        <div class="mt-0.5 text-indigo-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </div>
                        <p class="text-sm text-gray-700 flex-1">{{ $subtask }}</p>
                        <button wire:click="addSubtaskToForm('{{ addslashes($subtask) }}')" 
                            class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition hover:bg-indigo-200">
                            Gunakan
                        </button>
                    </div>
                @endforeach
            </div>
            <p class="text-xs text-indigo-500 mt-3 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Klik "Gunakan" untuk menyalin saran ke form tugas Anda.
            </p>
        </div>
    @endif
</div>
