<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-pastel-peach/30 shadow-sm">
        <h3 class="text-xl font-bold text-gray-800 mb-2">🏅 Galeri Lencana & Pencapaian</h3>
        <p class="text-sm text-gray-400">Penuhi kriteria pemicu dan selesaikan berbagai tantangan produktif untuk mengoleksi lencana prestasi!</p>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($badges as $badge)
            @php
                $isEarned = in_array($badge->id, $earnedBadgeIds);
                $earnedRecord = $isEarned ? auth()->user()->badges()->where('badge_id', $badge->id)->first() : null;
                $earnedAt = $earnedRecord ? \Carbon\Carbon::parse($earnedRecord->pivot->earned_at) : null;
                
                // Icon representation map
                $emoji = match($badge->icon) {
                    'heroicon-o-fire' => '🔥',
                    'heroicon-o-sparkles' => '✨',
                    'heroicon-o-trophy' => '🏆',
                    'heroicon-o-academic-cap' => '🎓',
                    'heroicon-o-clock' => '⏰',
                    'heroicon-o-check-circle' => '✅',
                    default => '🏅',
                };
            @endphp
            
            <div class="bg-white p-6 rounded-3xl border {{ $isEarned ? 'border-pastel-lavender bg-gradient-to-br from-white to-pastel-lavender/10 shadow-sm' : 'border-gray-100 opacity-60 grayscale' }} flex flex-col items-center text-center space-y-4 transition hover:-translate-y-1 hover:shadow-md duration-200">
                
                <!-- Badge Icon/Emoji Container -->
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center relative {{ $isEarned ? 'bg-pastel-lavender/50 text-indigo-600' : 'bg-gray-100 text-gray-400' }}">
                    @if($isEarned)
                        <div class="absolute -right-1 -top-1 w-5 h-5 rounded-full bg-emerald-400 flex items-center justify-center text-white text-[10px] font-bold">✓</div>
                    @endif
                    <!-- Fallback Emoji + Dynamic Icon -->
                    <div class="flex flex-col items-center">
                        <span class="text-3xl">{{ $emoji }}</span>
                    </div>
                </div>

                <!-- Badge Details -->
                <div class="space-y-1">
                    <h4 class="font-bold text-gray-800 text-base">{{ $badge->name }}</h4>
                    <p class="text-xs text-gray-500 max-w-[180px] mx-auto leading-relaxed">{{ $badge->description }}</p>
                </div>

                <!-- Earned Info or Requirement -->
                <div class="pt-2 w-full border-t border-gray-100 text-xs">
                    @if($isEarned)
                        <span class="font-bold text-indigo-600 block">Diperoleh 🎉</span>
                        <span class="text-[10px] text-gray-400 font-semibold">{{ $earnedAt ? $earnedAt->format('d M Y') : '' }}</span>
                    @else
                        <span class="font-bold text-gray-400 block uppercase tracking-wider text-[10px]">Syarat:</span>
                        <span class="text-[10px] text-gray-500 font-semibold">
                            @if($badge->rule_type === 'pomodoro_count')
                                Selesaikan {{ $badge->rule_value }} sesi Pomodoro
                            @elseif($badge->rule_type === 'task_completed')
                                Selesaikan {{ $badge->rule_value }} Tugas
                            @elseif($badge->rule_type === 'challenge_completed')
                                Selesaikan {{ $badge->rule_value }} Tantangan
                            @endif
                        </span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
