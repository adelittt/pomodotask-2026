<div>
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold text-gray-800 tracking-tight">Halo, <span class="text-red-400">{{ auth()->user()->name }}</span>! 👋</h2>
            <p class="text-gray-500 text-sm mt-1 font-medium">Mari fokus dan selesaikan lebih banyak hari ini!</p>
        </div>
        <div class="flex items-center gap-4">
            @livewire('notification-dropdown')
            <div class="flex items-center gap-2 bg-white border border-gray-100 px-4 py-2.5 rounded-xl shadow-sm text-sm font-semibold text-gray-600">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                {{ now()->translatedFormat('l, j F Y') }}
            </div>
        </div>
    </div>

    <!-- Grid Top: Pomodoro & Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        <!-- Pomodoro Timer Card (Alpine Data Attached) -->
        <div class="lg:col-span-5 bg-[#FFF5F6] rounded-[32px] p-8 border border-[#FFE4E8] relative overflow-hidden flex flex-col justify-between shadow-sm min-h-[300px]">
             
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xl">🍅</span>
                    <h3 class="font-bold text-gray-800">Pomodoro Timer</h3>
                    <span class="text-[10px] font-bold bg-green-100 text-green-600 px-2 py-0.5 rounded-full ml-1" x-text="mode === 'work' ? 'Sesi Fokus' : 'Istirahat'">Sesi Fokus</span>
                </div>
                
                <div class="text-[72px] font-black text-gray-800 tracking-tighter my-2 leading-none" x-text="formatTime()">25:00</div>
                
                <div class="flex flex-wrap items-center gap-2 mt-4 z-10 relative">
                    <button @click="toggleTimer()" 
                            class="bg-[#F46B7E] hover:bg-[#e05b6e] text-white font-bold py-3 px-5 rounded-2xl w-fit transition-all shadow-[0_4px_14px_rgba(244,107,126,0.4)] flex items-center gap-2 text-sm">
                        <svg x-show="!isPlaying" class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg> 
                        <svg x-show="isPlaying" class="w-4 h-4 fill-current" style="display:none;" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg> 
                        <span x-text="isPlaying ? 'Jeda' : 'Mulai Fokus'">Mulai Fokus</span>
                    </button>
                    
                    <button @click="resetTimer()" 
                            class="bg-white hover:bg-gray-50 text-gray-500 w-11 h-11 rounded-xl flex items-center justify-center font-bold text-sm shadow-sm transition shrink-0">
                        🔄
                    </button>
                    
                    <button @click="if (confirm('Simulasi sesi selesai sekarang?')) timerFinished()" 
                            class="bg-white hover:bg-gray-50 text-gray-500 w-11 h-11 rounded-xl flex items-center justify-center font-bold text-sm shadow-sm transition shrink-0"
                            title="Lompati Sesi (Simulasi)">
                        ⏭️
                    </button>
                </div>
                
                <div class="mt-4 max-w-[180px] sm:max-w-[220px] relative z-10">
                    <select x-model="activeTaskId" :disabled="isPlaying"
                        class="w-full bg-white/90 border border-[#FFE4E8] focus:border-red-400 rounded-xl py-2.5 px-3 pr-8 text-xs focus:outline-none transition font-bold text-gray-600 appearance-none shadow-sm cursor-pointer">
                        <option value="">Fokus Mandiri</option>
                        <option disabled>──────────</option>
                        <option value="belajar">Belajar</option>
                        <option value="work">Work</option>
                        <option value="project_pribadi">Project Pribadi</option>
                        <option value="lainnya">Lainnya</option>
                        <option disabled>──────────</option>
                        @foreach($tasks as $task)
                            <option value="{{ $task->id }}">{{ \Illuminate\Support\Str::limit($task->title, 18) }}</option>
                        @endforeach
                    </select>
                    <!-- Custom Arrow -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
            
            <div class="mt-6 z-10 relative">
                <p class="text-xs text-gray-500 font-semibold mb-3">Mode</p>
                <div class="flex flex-wrap gap-2">
                    <button @click="setMode('work')" 
                            :class="mode === 'work' ? 'bg-white border-gray-100 text-gray-800' : 'bg-white/60 border-transparent text-gray-500'" 
                            class="text-[11px] font-bold py-2 px-3 rounded-xl border shadow-sm flex items-center gap-1.5 transition">
                            <span class="text-red-400">🍅</span> Fokus
                    </button>
                    <button @click="setMode('short_break')" 
                            :class="mode === 'short_break' ? 'bg-white border-gray-100 text-gray-800' : 'bg-white/60 border-transparent text-gray-500'" 
                            class="text-[11px] font-bold py-2 px-3 rounded-xl border shadow-sm flex items-center gap-1.5 transition">
                            <span class="text-blue-400">☕</span> Istirahat Pendek
                    </button>
                    <button @click="setMode('long_break')" 
                            :class="mode === 'long_break' ? 'bg-white border-gray-100 text-gray-800' : 'bg-white/60 border-transparent text-gray-500'" 
                            class="text-[11px] font-bold py-2 px-3 rounded-xl border shadow-sm flex items-center gap-1.5 transition">
                            <span class="text-green-400">🌲</span> Istirahat Panjang
                    </button>
                </div>
            </div>

            <!-- Messages/Alerts from Livewire -->
            <div class="mt-4 z-10 relative">
                @if(session()->has('message'))
                    <div class="bg-white/80 text-emerald-600 p-2 rounded-xl text-xs font-bold shadow-sm">
                        {{ session('message') }}
                    </div>
                @endif
                @if(session()->has('timer_message'))
                    <div class="bg-white/80 text-amber-600 p-2 rounded-xl text-xs font-bold shadow-sm mt-2">
                        {{ session('timer_message') }}
                    </div>
                @endif
                @if(session()->has('badge_earned'))
                    <div class="bg-pastel-lavender/80 text-indigo-700 p-2 rounded-xl text-xs font-bold shadow-sm mt-2 animate-bounce">
                        {{ session('badge_earned') }}
                    </div>
                @endif
            </div>

            <!-- Cute Illustration Right -->
            <div class="absolute right-0 bottom-12 translate-x-4">
                <div class="w-48 h-48 bg-[#FFE4E8]/50 rounded-full absolute -z-10 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 blur-lg"></div>
                <div class="text-[140px] drop-shadow-xl relative" :class="isPlaying ? 'animate-pulse' : ''">
                    <span x-show="mode === 'work'">🍅</span>
                    <span x-show="mode === 'short_break'" style="display:none;">☕</span>
                    <span x-show="mode === 'long_break'" style="display:none;">🌲</span>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-12 h-6 flex gap-3 mt-8">
                            <div class="w-2 h-2 bg-gray-800 rounded-full" :class="isPlaying ? 'animate-ping' : ''"></div>
                            <div class="w-2 h-2 bg-gray-800 rounded-full" :class="isPlaying ? 'animate-ping' : ''"></div>
                        </div>
                        <div class="absolute mt-10 w-3 h-1.5 border-b-2 border-gray-800 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tugas Mendatang (Dinamis dari Livewire!) -->
        <div class="lg:col-span-7 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm flex flex-col min-h-[300px]">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-gray-800 flex items-center gap-2 text-sm"><span class="text-lg">📋</span> Tugas Mendatang</h3>
                <button @click="activeTab = 'tasks'" class="text-xs font-bold text-[#F46B7E] bg-[#FFF5F6] hover:bg-[#FFE4E8] px-3 py-1.5 rounded-lg transition">Lihat Semua</button>
            </div>
            <div class="space-y-2 flex-1 overflow-y-auto max-h-[200px] pr-2">
                @forelse($upcomingTasks as $task)
                    @php
                        $progressVal = $task->progress ?? 0;
                        $progressColor = $progressVal == 100 ? 'bg-emerald-400' : ($progressVal >= 50 ? 'bg-blue-400' : 'bg-[#F46B7E]');
                    @endphp
                    <div @click="promptTaskSession('{{ $task->id }}', '{{ addslashes($task->title) }}')" 
                         class="group relative flex flex-col p-4 bg-white hover:bg-gray-50/80 rounded-2xl transition-all cursor-pointer gap-4 border border-gray-100 hover:border-gray-200 shadow-sm hover:shadow-md">

                        <div class="flex items-start justify-between w-full gap-4">
                            <div class="flex items-start gap-3 flex-1 min-w-0">
                                <button wire:click.stop="toggleStatus({{ $task->id }})" class="mt-0.5 w-5 h-5 flex-shrink-0 rounded-full border-[2.5px] bg-white hover:bg-gray-50 transition focus:outline-none flex items-center justify-center {{ $task->priority == 'high' ? 'border-red-400' : ($task->priority == 'medium' ? 'border-yellow-400' : 'border-green-400') }}">
                                    @if($task->status === 'completed')
                                        <div class="w-3 h-3 rounded-full {{ $task->priority == 'high' ? 'bg-red-400' : ($task->priority == 'medium' ? 'bg-yellow-400' : 'bg-green-400') }}"></div>
                                    @endif
                                </button>
                                <div class="flex flex-col gap-1 w-full">
                                    <span class="text-sm font-bold text-gray-800 leading-tight {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }} group-hover:text-[#F46B7E] transition-colors truncate">{{ $task->title }}</span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="text-xs font-bold text-gray-500 flex items-center gap-1">🗓️ {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M') : '-' }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex-shrink-0 relative">
                                <div class="group-hover:opacity-0 transition-opacity duration-200">
                                    @if($task->priority == 'high')
                                        <span class="text-xs font-bold bg-red-50 text-red-500 px-2 py-1 rounded-md flex items-center gap-1 shadow-sm"><span class="w-2 h-2 rounded-full bg-red-500"></span> Tinggi</span>
                                    @elseif($task->priority == 'medium')
                                        <span class="text-xs font-bold bg-yellow-50 text-yellow-600 px-2 py-1 rounded-md flex items-center gap-1 shadow-sm"><span class="w-2 h-2 rounded-full bg-yellow-500"></span> Sedang</span>
                                    @else
                                        <span class="text-xs font-bold bg-green-50 text-green-600 px-2 py-1 rounded-md flex items-center gap-1 shadow-sm"><span class="w-2 h-2 rounded-full bg-green-500"></span> Rendah</span>
                                    @endif
                                </div>
                                
                                <div class="absolute right-0 top-0 opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-[#F46B7E] font-bold text-xs bg-white px-2 py-1 rounded-md shadow-sm border border-[#FFE4E8] flex items-center gap-1 whitespace-nowrap">
                                    ▶ Mulai
                                </div>
                            </div>
                        </div>
                        
                        <div class="pl-8 flex items-center justify-between gap-4">
                            <div class="w-full">
                                <div class="flex justify-between items-center mb-1.5">
                                    <span class="text-[10px] font-extrabold tracking-wider uppercase text-gray-400">Progress</span>
                                    <span class="text-[10px] font-extrabold text-gray-600">{{ $progressVal }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                                    <div class="{{ $progressColor }} h-full rounded-full transition-all duration-300 relative" style="width: {{ $progressVal }}%">
                                        <div class="absolute top-0 bottom-0 left-0 right-0 bg-white/20 w-full animate-pulse"></div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex flex-col items-end shrink-0 bg-white px-3 py-1.5 rounded-lg border border-gray-100 shadow-sm group-hover:border-red-100 transition-colors">
                                <span class="text-sm font-black text-gray-700 flex items-center gap-1.5">
                                    <span class="text-xl">🍅</span> {{ $task->completed_pomodoros }}<span class="text-gray-400 font-bold">/{{ $task->estimated_pomodoros }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center text-sm text-gray-500 font-medium h-full flex items-center justify-center">Belum ada tugas mendatang.</div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Grid Middle: Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
        <!-- Fokus Mingguan Chart (Tetap statis mockup, tapi UI aman) -->
        <div class="lg:col-span-7 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h3 class="font-bold text-gray-800 flex items-center gap-2 text-sm"><span class="text-lg">📊</span> Fokus Mingguan</h3>
                <select class="text-xs font-bold text-gray-500 bg-gray-50 border-none rounded-xl py-2 px-3 focus:ring-0 outline-none cursor-pointer">
                    <option>7 Hari Terakhir</option>
                </select>
            </div>
            <div class="h-48 relative flex items-end justify-between px-4 pb-2">
                <div class="absolute inset-0 flex flex-col justify-between text-[10px] font-bold text-gray-400 pb-6 pointer-events-none">
                    <div class="w-full border-b border-gray-100 flex items-center gap-3"><span class="w-4">8h</span></div>
                    <div class="w-full border-b border-gray-100 flex items-center gap-3"><span class="w-4">6h</span></div>
                    <div class="w-full border-b border-gray-100 flex items-center gap-3"><span class="w-4">4h</span></div>
                    <div class="w-full border-b border-gray-100 flex items-center gap-3"><span class="w-4">2h</span></div>
                    <div class="w-full border-b border-gray-100 flex items-center gap-3"><span class="w-4">0m</span></div>
                </div>
                <!-- Real Bars based on $weeklyFocus -->
                @foreach($weeklyFocus as $focus)
                <div class="relative z-10 w-8 bg-[#FFD1DC] rounded-t-lg flex flex-col justify-end items-center mx-auto transition-all duration-500" style="height: {{ $focus['percentage'] }}%;">
                    <!-- Tooltip (Opsional, untuk melihat nilai) -->
                    <div class="absolute -top-8 bg-gray-800 text-white text-[10px] py-1 px-2 rounded opacity-0 hover:opacity-100 cursor-default">
                        {{ floor($focus['duration'] / 60) }}h {{ $focus['duration'] % 60 }}m
                    </div>
                    <span class="absolute -bottom-7 text-[11px] text-gray-500 font-bold">{{ $focus['day'] }}</span>
                    <div class="w-2.5 h-2.5 rounded-full {{ $focus['duration'] > 0 ? 'bg-green-400' : 'bg-gray-300' }} absolute -top-1.5 border-2 border-white"></div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Distribusi Fokus (Mockup) -->
        <div class="lg:col-span-5 bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
            <h3 class="font-bold text-gray-800 mb-8 flex items-center gap-2 text-sm"><span class="text-lg">🥧</span> Distribusi Fokus</h3>
            <div class="flex items-center justify-between px-2">
                <div class="w-36 h-36 relative rounded-full" style="background: conic-gradient(#86efac 0% 45%, #fca5a5 45% 75%, #fde047 75% 90%, #c4b5fd 90% 100%);">
                    <div class="absolute inset-[18px] bg-white rounded-full flex flex-col items-center justify-center">
                        <span class="text-[10px] font-bold text-gray-400">Total</span>
                        <span class="text-sm font-black text-gray-800">{{ $waktuFokusJam }}j {{ $waktuFokusMenit }}m</span>
                    </div>
                </div>
                <div class="space-y-4 flex-1 ml-8">
                    <div class="flex justify-between items-center text-xs">
                        <div class="flex items-center gap-2 font-bold text-gray-600"><span class="w-2 h-2 rounded-full bg-green-400"></span> Belajar</div>
                        <span class="font-black text-gray-800">45%</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <div class="flex items-center gap-2 font-bold text-gray-600"><span class="w-2 h-2 rounded-full bg-red-300"></span> Work</div>
                        <span class="font-black text-gray-800">30%</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <div class="flex items-center gap-2 font-bold text-gray-600"><span class="w-2 h-2 rounded-full bg-yellow-300"></span> Project Pribadi</div>
                        <span class="font-black text-gray-800">15%</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <div class="flex items-center gap-2 font-bold text-gray-600"><span class="w-2 h-2 rounded-full bg-purple-300"></span> Lainnya</div>
                        <span class="font-black text-gray-800">10%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Bottom: Tugas & Pencapaian -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white border border-gray-100 rounded-3xl p-5 shadow-sm flex flex-col justify-between">
                <div class="w-10 h-10 rounded-full bg-green-50 text-green-500 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-500 mb-1">Tugas Selesai</h4>
                    <div class="text-3xl font-black text-gray-800 mb-2">{{ $tasksCompleted }}</div>
                </div>
            </div>
            
            <div class="bg-white border border-gray-100 rounded-3xl p-5 shadow-sm flex flex-col justify-between">
                <div class="w-10 h-10 rounded-full bg-red-50 text-red-400 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-500 mb-1">Waktu Fokus</h4>
                    <div class="text-3xl font-black text-gray-800 mb-2">{{ $waktuFokusJam }}j <span class="text-xl">{{ $waktuFokusMenit }}m</span></div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-3xl p-5 shadow-sm flex flex-col justify-between">
                <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-400 flex items-center justify-center mb-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path></svg>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-500 mb-1">Streak</h4>
                    <div class="text-3xl font-black text-gray-800 mb-2">3</div>
                    <div class="text-[10px] font-bold text-gray-400">hari berturut-turut 🎉</div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-3xl p-5 shadow-sm flex flex-col justify-between">
                <div class="w-10 h-10 rounded-full bg-[#FFE4E8] text-red-500 flex items-center justify-center mb-3">
                    <span class="text-lg">🍅</span>
                </div>
                <div>
                    <h4 class="text-xs font-bold text-gray-500 mb-1">Pomodoro</h4>
                    <div class="text-3xl font-black text-gray-800 mb-2">{{ $totalPomodorosReal }}</div>
                </div>
            </div>
        </div>

        <!-- Pencapaian Terbaru (Mockup) -->
        <div class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-gray-800 flex items-center gap-2 text-sm"><span class="text-lg">🏆</span> Pencapaian Terbaru</h3>
                <button @click="activeTab = 'badges'" class="text-xs font-bold text-[#F46B7E] bg-[#FFF5F6] hover:bg-[#FFE4E8] px-3 py-1.5 rounded-lg transition">Lihat Semua</button>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-[#F8FDF9] border border-[#E1F7E8] rounded-2xl p-4 flex flex-col items-center text-center shadow-sm">
                    <div class="w-14 h-14 bg-[#E1F7E8] rounded-full flex items-center justify-center text-3xl mb-3 relative">
                        🎯
                        <div class="absolute -bottom-1 -right-1 bg-green-500 w-5 h-5 rounded-full border-2 border-white flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <h4 class="text-[11px] font-extrabold text-gray-800">Fokus Master</h4>
                    <p class="text-[9px] font-medium text-gray-500 mt-1 mb-2 leading-tight">Selesaikan 10 sesi fokus</p>
                    <span class="text-[9px] font-bold text-gray-400 mt-auto">02 Jun 2026</span>
                </div>
                <div class="bg-[#FFF5F6] border border-[#FFE4E8] rounded-2xl p-4 flex flex-col items-center text-center shadow-sm">
                    <div class="w-14 h-14 bg-[#FFE4E8] rounded-full flex items-center justify-center text-3xl mb-3 relative">
                        🔥
                        <div class="absolute -bottom-1 -right-1 bg-red-400 w-5 h-5 rounded-full border-2 border-white flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <h4 class="text-[11px] font-extrabold text-gray-800">On Fire</h4>
                    <p class="text-[9px] font-medium text-gray-500 mt-1 mb-2 leading-tight">3 hari berturut-turut fokus</p>
                    <span class="text-[9px] font-bold text-gray-400 mt-auto">02 Jun 2026</span>
                </div>
                <div class="bg-[#F8FDF9] border border-[#E1F7E8] rounded-2xl p-4 flex flex-col items-center text-center shadow-sm">
                    <div class="w-14 h-14 bg-[#E1F7E8] rounded-full flex items-center justify-center text-3xl mb-3 relative">
                        🍅
                        <div class="absolute -bottom-1 -right-1 bg-green-500 w-5 h-5 rounded-full border-2 border-white flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <h4 class="text-[11px] font-extrabold text-gray-800">Pomodoro Pro</h4>
                    <p class="text-[9px] font-medium text-gray-500 mt-1 mb-2 leading-tight">Selesaikan 25 pomodoro</p>
                    <span class="text-[9px] font-bold text-gray-400 mt-auto">01 Jun 2026</span>
                </div>
            </div>
        </div>
    </div>
</div>
