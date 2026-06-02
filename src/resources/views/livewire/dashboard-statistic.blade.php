<div class="space-y-8">
    <!-- Summary Metrics Cards Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1: Waktu Fokus -->
        <div class="bg-white p-6 rounded-3xl border border-pastel-pink/40 shadow-sm flex items-center gap-4 relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-pastel-pink/20 rounded-full"></div>
            <span class="text-3xl bg-pastel-pink/30 p-3 rounded-2xl">⏰</span>
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Total Waktu</span>
                <span class="text-2xl font-bold text-gray-800">{{ $totalFocusHours }} Jam</span>
                <span class="text-[10px] text-gray-400 block mt-0.5">{{ $totalSessions }} Sesi Fokus</span>
            </div>
        </div>

        <!-- Card 2: Tugas Selesai -->
        <div class="bg-white p-6 rounded-3xl border border-pastel-mint/40 shadow-sm flex items-center gap-4 relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-pastel-mint/20 rounded-full"></div>
            <span class="text-3xl bg-pastel-mint/30 p-3 rounded-2xl">✅</span>
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Tugas Selesai</span>
                <span class="text-2xl font-bold text-gray-800">{{ $completedTasks }} / {{ $totalTasks }}</span>
                <span class="text-[10px] text-gray-400 block mt-0.5">{{ $pendingTasks }} Tugas Tertunda</span>
            </div>
        </div>

        <!-- Card 3: Badge Koleksi -->
        <div class="bg-white p-6 rounded-3xl border border-pastel-lavender/40 shadow-sm flex items-center gap-4 relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-pastel-lavender/20 rounded-full"></div>
            <span class="text-3xl bg-pastel-lavender/30 p-3 rounded-2xl">🏅</span>
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Koleksi Lencana</span>
                <span class="text-2xl font-bold text-gray-800">{{ $earnedBadges }} Badge</span>
                <span class="text-[10px] text-gray-400 block mt-0.5">Dari Galeri Prestasi</span>
            </div>
        </div>

        <!-- Card 4: Tantangan Berjalan -->
        <div class="bg-white p-6 rounded-3xl border border-pastel-blue/40 shadow-sm flex items-center gap-4 relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-16 h-16 bg-pastel-blue/20 rounded-full"></div>
            <span class="text-3xl bg-pastel-blue/30 p-3 rounded-2xl">🚀</span>
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block">Tantangan Aktif</span>
                <span class="text-2xl font-bold text-gray-800">{{ $activeChallenges }} Diikuti</span>
                <span class="text-[10px] text-gray-400 block mt-0.5">Sedang Berjalan</span>
            </div>
        </div>
    </div>

    <!-- Chart & Recent Activities Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Weekly Progress CSS Chart (2/3) -->
        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-pastel-peach/30 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-gray-800 mb-1">📊 Tren Fokus Mingguan</h3>
                <p class="text-xs text-gray-400 mb-6">Total waktu fokus (menit) yang diselesaikan dalam 7 hari terakhir.</p>
            </div>

            <!-- Bar Chart Container -->
            <div class="h-64 flex items-end justify-around gap-2 px-2 border-b border-gray-100 pb-2">
                @foreach($weeklyStats as $stat)
                    @php
                        // Hitung tinggi persen bar relatif terhadap maxMinutes
                        $heightPercent = max(6, round(($stat['minutes'] / $maxMinutes) * 100));
                    @endphp
                    <div class="flex flex-col items-center flex-grow group max-w-[50px]">
                        <!-- Tooltip on hover -->
                        <span class="opacity-0 group-hover:opacity-100 bg-gray-800 text-white text-[10px] font-bold px-2 py-1 rounded-lg mb-2 transition duration-200 pointer-events-none">
                            {{ $stat['minutes'] }}m
                        </span>
                        
                        <!-- The Bar -->
                        <div class="w-full bg-gradient-to-t from-[#B5E3F7]/60 to-[#FFD1DC]/80 rounded-t-xl transition-all duration-500 ease-out hover:from-[#B5E3F7] hover:to-[#FFD1DC]"
                             style="height: {{ $heightPercent }}px;"></div>
                        
                        <!-- Day/Date labels -->
                        <span class="text-xs font-bold text-gray-600 mt-2 block">{{ $stat['day'] }}</span>
                        <span class="text-[9px] text-gray-400 font-semibold block">{{ $stat['date'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Focus Sessions (1/3) -->
        <div class="bg-white p-6 rounded-3xl border border-pastel-peach/30 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-4">📜 Aktivitas Terbaru</h3>
            
            @if(count($recentSessions) === 0)
                <div class="text-center py-12">
                    <span class="text-3xl text-gray-300">⏳</span>
                    <h5 class="font-bold text-gray-400 mt-2">Belum ada riwayat sesi</h5>
                    <p class="text-[11px] text-gray-400">Jalankan timer Pomodoro sekarang!</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($recentSessions as $sess)
                        @php
                            $sessTypeColor = match($sess->type) {
                                'work' => 'bg-pastel-pink/40 text-[#D04D54]',
                                'short_break' => 'bg-[#BAFFC9]/40 text-[#3C8A53]',
                                'long_break' => 'bg-[#B5E3F7]/40 text-[#297C9B]',
                                default => 'bg-gray-100 text-gray-600',
                            };
                            
                            $sessTypeName = match($sess->type) {
                                'work' => 'Fokus',
                                'short_break' => 'Istirahat',
                                'long_break' => 'Santai',
                                default => 'Sesi',
                            };
                        @endphp
                        <div class="flex items-start justify-between gap-3 text-xs pb-3 border-b border-gray-100 last:border-b-0 last:pb-0">
                            <div class="space-y-0.5">
                                <span class="font-bold text-gray-700 block">
                                    {{ $sess->task ? $sess->task->title : 'Fokus Mandiri' }}
                                </span>
                                <span class="text-[10px] text-gray-400 block font-semibold">
                                    {{ $sess->completed_at ? $sess->completed_at->diffForHumans() : '' }}
                                </span>
                            </div>
                            <div class="text-right space-y-1">
                                <span class="px-2 py-0.5 rounded-lg font-bold uppercase tracking-wider text-[9px] block {{ $sessTypeColor }}">
                                    {{ $sessTypeName }}
                                </span>
                                <span class="text-[10px] text-gray-500 font-bold block">
                                    {{ $sess->duration }} mnt
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
