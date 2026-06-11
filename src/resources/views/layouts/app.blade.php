<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PomoTasky - Fokus dengan Gaya Pastel Soft</title>
    <!-- Import Google Fonts Quicksand & Montserrat -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700;800&family=Montserrat:wght@400;500;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Quicksand', 'Montserrat', sans-serif;
            background-color: #FDF8F5;
        }
        .sidebar-scroll::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background-color: #FEE2E2; 
            border-radius: 4px;
        }
        .main-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .main-scroll::-webkit-scrollbar-thumb {
            background-color: #fca5a5; 
            border-radius: 6px;
        }
    </style>

    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="text-gray-700 antialiased overflow-hidden">
    <div x-data="{ activeTab: 'home' }" class="flex h-screen bg-[#FDF8F5]">
        
        <!-- Sidebar -->
        <aside class="w-[280px] bg-white border-r border-red-50 flex flex-col justify-between overflow-y-auto sidebar-scroll h-full shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-20 shrink-0">
            <div>
                <!-- Logo -->
                <div class="px-6 pt-8 pb-6 flex items-center gap-3">
                    <span class="text-3xl drop-shadow-sm">🍅</span>
                    <span class="text-2xl font-extrabold text-gray-800 tracking-tight">Pomo<span class="text-red-400">Tasky</span></span>
                </div>

                <!-- Navigation -->
                <nav class="px-4 space-y-1.5 mt-2">
                    <button @click="activeTab = 'home'" :class="activeTab === 'home' ? 'bg-red-50 text-red-500 font-bold' : 'text-gray-500 hover:bg-gray-50 font-semibold'" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Beranda
                    </button>
                    <button @click="activeTab = 'tasks'" :class="activeTab === 'tasks' ? 'bg-red-50 text-red-500 font-bold' : 'text-gray-500 hover:bg-gray-50 font-semibold'" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Tugas Saya
                    </button>
                    <button @click="activeTab = 'pomodoro'" :class="activeTab === 'pomodoro' ? 'bg-red-50 text-red-500 font-bold' : 'text-gray-500 hover:bg-gray-50 font-semibold'" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Pomodoro Timer
                    </button>
                    <button @click="activeTab = 'challenges'" :class="activeTab === 'challenges' ? 'bg-red-50 text-red-500 font-bold' : 'text-gray-500 hover:bg-gray-50 font-semibold'" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        Tantangan
                    </button>
                    <button @click="activeTab = 'badges'" :class="activeTab === 'badges' ? 'bg-red-50 text-red-500 font-bold' : 'text-gray-500 hover:bg-gray-50 font-semibold'" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        Badge Saya
                    </button>
                    <button @click="activeTab = 'statistics'" :class="activeTab === 'statistics' ? 'bg-red-50 text-red-500 font-bold' : 'text-gray-500 hover:bg-gray-50 font-semibold'" class="w-full flex items-center gap-3 px-4 py-3 rounded-2xl transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Statistik Fokus
                    </button>
                </nav>

                <!-- Widgets -->
                <div class="px-4 mt-8 space-y-4">
                    <!-- Tetap Konsisten Widget -->
                    <div class="bg-[#FFF5F6] border border-[#FFE4E8] rounded-3xl p-5 relative overflow-hidden">
                        <h4 class="font-bold text-[#F46B7E] text-sm mb-2 flex items-center gap-1">Tetap Konsisten! 🌸</h4>
                        <p class="text-xs text-gray-600 mb-4 leading-relaxed">Kamu sudah fokus selama<br>3 hari berturut-turut.</p>
                        
                        <div class="flex items-center gap-0.5">
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            <div class="w-8 h-[2px] bg-green-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            <div class="w-8 h-[2px] bg-green-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                            <div class="w-8 h-[2px] bg-gray-300"></div>
                            <div class="w-3 h-3 rounded-full border-2 border-gray-300 bg-white"></div>
                        </div>

                        <!-- Cute Tomato Icon -->
                        <div class="absolute -bottom-2 -right-2 text-[40px] opacity-90 drop-shadow-md">
                            🍅
                        </div>
                    </div>

                    <!-- Quote Widget -->
                    <div class="bg-[#FFF5F6] border border-[#FFE4E8] rounded-3xl p-5 relative">
                        <div class="text-[#F46B7E] text-4xl font-serif absolute -top-1 left-4 opacity-30 leading-none">“</div>
                        <p class="text-xs text-gray-600 font-medium leading-relaxed mt-2 italic relative z-10">"Disiplin hari ini adalah kebebasan di masa depan."</p>
                    </div>
                </div>
            </div>

            <!-- Profile Info (Bottom) -->
            <div class="p-4 mt-6 mb-2">
                @auth
                <div x-data="{ open: false }" class="relative">
                    <div @click="open = !open" class="flex items-center justify-between p-3 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition cursor-pointer">
                        <div class="flex items-center gap-3">
                            <img src="{{ auth()->user()->getFilamentAvatarUrl() }}" class="w-9 h-9 rounded-full border border-gray-200" alt="Avatar">
                            <div class="flex flex-col">
                                <span class="text-xs font-extrabold text-gray-800 leading-tight">{{ auth()->user()->name }}</span>
                                <span class="text-[10px] text-gray-500 truncate max-w-[120px]">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <svg class="w-4 h-4 text-gray-400" :class="open ? 'rotate-180' : ''" class="transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <!-- Dropdown Logout -->
                    <div x-show="open" style="display: none;" @click.away="open = false" x-transition class="absolute bottom-full mb-2 w-full bg-white border border-gray-100 rounded-xl shadow-[0_-4px_14px_rgba(0,0,0,0.05)] p-2 z-50">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-xs text-red-500 font-bold hover:bg-[#FFF5F6] rounded-lg transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Keluar Aplikasi
                            </button>
                        </form>
                    </div>
                </div>
                @endauth
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="flex-1 flex flex-col h-screen overflow-y-auto main-scroll relative" x-data="pomodoroTimerState()">
            @yield('content')
            {{ $slot ?? '' }}
        </main>
    </div>

    @livewireScripts
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pomodoroTimerState', () => ({
                mode: 'work',
                secondsRemaining: 25 * 60,
                isPlaying: false,
                timerId: null,
                totalDuration: 25 * 60,
                activeTaskId: '',
                
                init() {
                    this.resetTimer();
                },
                
                setMode(newMode) {
                    this.isPlaying = false;
                    clearInterval(this.timerId);
                    this.timerId = null;
                    this.mode = newMode;
                    this.resetTimer();
                },
                
                resetTimer() {
                    this.isPlaying = false;
                    clearInterval(this.timerId);
                    this.timerId = null;
                    if (this.mode === 'work') {
                        this.secondsRemaining = 25 * 60;
                    } else if (this.mode === 'short_break') {
                        this.secondsRemaining = 5 * 60;
                    } else if (this.mode === 'long_break') {
                        this.secondsRemaining = 15 * 60;
                    }
                    this.totalDuration = this.secondsRemaining;
                },
                
                toggleTimer() {
                    if (this.isPlaying) {
                        this.pauseTimer();
                    } else {
                        this.startTimer();
                    }
                },
                
                startTimer() {
                    this.isPlaying = true;
                    this.timerId = setInterval(() => {
                        if (this.secondsRemaining > 0) {
                            this.secondsRemaining--;
                        } else {
                            this.timerFinished();
                        }
                    }, 1000);
                },
                
                pauseTimer() {
                    this.isPlaying = false;
                    clearInterval(this.timerId);
                    this.timerId = null;
                },
                
                timerFinished() {
                    this.pauseTimer();
                    this.playBellSound();
                    
                    let durationMinutes = Math.ceil(this.totalDuration / 60);
                    let taskId = this.activeTaskId;
                    
                    // Dispatch Livewire event instead of $wire.saveSession
                    Livewire.dispatch('savePomodoroSession', { taskId: taskId, duration: durationMinutes, type: this.mode });
                    this.resetTimer();
                },
                
                playBellSound() {
                    try {
                        const audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                        this.playTone(audioCtx, 523.25, 0.4);
                        setTimeout(() => { this.playTone(audioCtx, 659.25, 0.4); }, 300);
                        setTimeout(() => { this.playTone(audioCtx, 783.99, 0.8); }, 600);
                    } catch (e) { console.log('AudioContext error:', e); }
                },
                
                playTone(ctx, freq, duration) {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(freq, ctx.currentTime);
                    gain.gain.setValueAtTime(0.3, ctx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + duration);
                    osc.start(ctx.currentTime);
                    osc.stop(ctx.currentTime + duration);
                },
                
                formatTime() {
                    let minutes = Math.floor(this.secondsRemaining / 60);
                    let seconds = this.secondsRemaining % 60;
                    return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                },
                
                getProgressPercent() {
                    return ((this.totalDuration - this.secondsRemaining) / this.totalDuration) * 100;
                }
            }));
        });
    </script>
    @stack('scripts')
</body>
</html>