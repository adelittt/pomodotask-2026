<div class="max-w-xl mx-auto">
    
    <!-- Timer Card -->
    <div class="bg-white p-8 rounded-3xl border border-pastel-peach/30 shadow-sm text-center relative overflow-hidden">
        <div class="absolute -right-24 -bottom-24 w-48 h-48 bg-[#BAFFC9]/20 rounded-full blur-3xl"></div>
        <div class="absolute -left-24 -top-24 w-48 h-48 bg-[#FFB3BA]/20 rounded-full blur-3xl"></div>
        
        <!-- Notifikasi Sesi & Lencana -->
        @if(session()->has('message'))
            <div class="mb-6 bg-pastel-mint/40 text-emerald-700 border border-pastel-mint p-3 rounded-2xl text-sm font-semibold">
                {{ session('message') }}
            </div>
        @endif

        @if(session()->has('timer_message'))
            <div class="mb-6 bg-pastel-yellow/50 text-amber-800 border border-pastel-yellow p-3 rounded-2xl text-sm font-semibold">
                {{ session('timer_message') }}
            </div>
        @endif

        @if(session()->has('badge_earned'))
            <div class="mb-6 bg-pastel-lavender/50 text-indigo-700 border border-pastel-lavender p-3 rounded-2xl text-sm font-bold animate-bounce">
                {{ session('badge_earned') }}
            </div>
        @endif

        <!-- Mode Switcher Buttons -->
        <div class="flex justify-center gap-2 mb-8 bg-gray-50 border p-1.5 rounded-2xl max-w-max mx-auto relative z-10">
            <button @click="setMode('work')"
                :class="mode === 'work' ? 'bg-[#FFB3BA]/40 text-[#D04D54] border border-[#FFD1DC] font-extrabold' : 'text-gray-500 hover:text-gray-700'"
                class="px-4 py-2 rounded-xl text-xs font-bold transition">
                🍅 Kerja (25m)
            </button>
            <button @click="setMode('short_break')"
                :class="mode === 'short_break' ? 'bg-[#BAFFC9]/40 text-[#3C8A53] border border-[#C1E1C1] font-extrabold' : 'text-gray-500 hover:text-gray-700'"
                class="px-4 py-2 rounded-xl text-xs font-bold transition">
                ☕ Istirahat (5m)
            </button>
            <button @click="setMode('long_break')"
                :class="mode === 'long_break' ? 'bg-[#B5E3F7]/40 text-[#297C9B] border border-[#B5E3F7] font-extrabold' : 'text-gray-500 hover:text-gray-700'"
                class="px-4 py-2 rounded-xl text-xs font-bold transition">
                🌴 Santai (15m)
            </button>
        </div>

        <!-- Task Selector dropdown -->
        <div class="mb-8 max-w-sm mx-auto relative z-10">
            <label class="block text-xs font-bold text-gray-400 uppercase mb-2">Fokus Pada Tugas:</label>
            <select x-model="activeTaskId" :disabled="isPlaying"
                class="w-full bg-[#FFFDF6] border border-pastel-peach/40 focus:border-pastel-blue rounded-xl p-3 text-sm focus:outline-none transition {{ $activeTaskId ? 'border-pastel-blue' : '' }}">
                <option value="">-- Pilih Tugas atau Kategori --</option>
                <optgroup label="Tugas Aktif">
                    @foreach($tasks as $task)
                        <option value="{{ $task->id }}">
                            {{ $task->title }} (🍅 {{ $task->completed_pomodoros }}/{{ $task->estimated_pomodoros }})
                        </option>
                    @endforeach
                </optgroup>
                <optgroup label="Kategori Mandiri">
                    <option value="Belajar">Belajar</option>
                    <option value="Kerja">Kerja</option>
                    <option value="Proyek">Proyek</option>
                    <option value="Lainnya">Lainnya</option>
                </optgroup>
            </select>
        </div>

        <!-- Circular Progress & Digital Display -->
        <div class="relative w-64 h-64 mx-auto mb-8 flex items-center justify-center">
            <!-- SVG Progress Circle -->
            <svg class="absolute inset-0 w-full h-full transform -rotate-90">
                <circle cx="128" cy="128" r="110" stroke="#F3F4F6" stroke-width="12" fill="transparent" />
                <circle cx="128" cy="128" r="110" 
                    :stroke="mode === 'work' ? '#FFB3BA' : (mode === 'short_break' ? '#BAFFC9' : '#B5E3F7')" 
                    stroke-width="12" fill="transparent"
                    stroke-dasharray="691.15"
                    :stroke-dashoffset="691.15 - (691.15 * getProgressPercent()) / 100"
                    stroke-linecap="round"
                    class="transition-all duration-300 ease-out" />
            </svg>

            <!-- Digital Clock Display -->
            <div class="relative z-10">
                <span x-text="formatTime()" class="text-5xl font-bold text-gray-800 tracking-wider">25:00</span>
                <span x-text="mode === 'work' ? 'KERJA 💪' : (mode === 'short_break' ? 'ISTIRAHAT ☕' : 'SANTAI 🌴')" 
                    class="block text-xs font-bold tracking-widest text-gray-400 uppercase mt-2">KERJA 💪</span>
            </div>
        </div>

        <!-- Control Buttons -->
        <div class="flex justify-center items-center gap-4 relative z-10">
            <!-- Reset Button -->
            <button @click="resetTimer()" 
                class="bg-gray-100 hover:bg-gray-200 text-gray-500 w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-sm shadow-sm transition">
                🔄
            </button>

            <!-- Play/Pause Button -->
            <button @click="toggleTimer()" 
                :class="isPlaying ? 'bg-[#FFD1DC] hover:bg-[#FFB3BA] text-[#D04D54]' : 'bg-[#BAFFC9] hover:bg-[#A9EAA9] text-[#296D3B]'"
                class="px-8 py-4 rounded-2xl text-base font-bold shadow-md transition-all duration-200 flex items-center gap-2">
                <span x-text="isPlaying ? '⏸️ Jeda' : '▶️ Mulai'">▶️ Mulai</span>
            </button>

            <!-- Skip Button (Manual Trigger for Testing) -->
            <button @click="if (confirm('Simulasi sesi selesai sekarang?')) timerFinished()" 
                class="bg-gray-100 hover:bg-gray-200 text-gray-500 w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-sm shadow-sm transition"
                title="Lompati Sesi (Simulasi)">
                ⏭️
            </button>
        </div>
    </div>
</div>
