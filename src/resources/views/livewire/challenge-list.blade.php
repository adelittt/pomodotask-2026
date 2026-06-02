<div class="space-y-6">
    <div class="bg-white p-6 rounded-3xl border border-pastel-peach/30 shadow-sm">
        <h3 class="text-xl font-bold text-gray-800 mb-2">🏆 Tantangan Produktivitas</h3>
        <p class="text-sm text-gray-400">Ikuti tantangan fokus untuk menguji batasan diri dan dapatkan lencana eksklusif setelah menyelesaikannya!</p>
    </div>

    @if(session()->has('message'))
        <div class="bg-pastel-mint/40 text-emerald-700 border border-pastel-mint p-4 rounded-2xl text-sm font-semibold">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($challenges as $chall)
            @php
                $userChall = $userChallenges->get($chall->id);
                $isJoined = !is_null($userChall);
                $isCompleted = $isJoined && $userChall->status === 'completed';
                
                $percent = 0;
                if ($isJoined) {
                    $percent = min(100, round(($userChall->progress_hours / $chall->target_hours) * 100));
                }
            @endphp
            
            <div class="bg-white p-6 rounded-3xl border border-pastel-peach/20 shadow-sm flex flex-col justify-between relative overflow-hidden group hover:shadow transition-all duration-200">
                <!-- Background soft blur decoration -->
                <div class="absolute -right-16 -top-16 w-32 h-32 bg-pastel-lavender/25 rounded-full blur-2xl group-hover:bg-pastel-blue/25 transition"></div>

                <div class="relative z-10 space-y-4">
                    <!-- Top section badge/title -->
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <h4 class="text-lg font-bold text-gray-800">{{ $chall->title }}</h4>
                            <p class="text-xs text-gray-400 font-semibold mt-0.5">
                                Durasi: {{ $chall->duration_weeks }} Minggu | 📅 {{ $chall->start_date ? $chall->start_date->format('d M') : 'Mulai kapan saja' }} - {{ $chall->end_date ? $chall->end_date->format('d M Y') : '' }}
                            </p>
                        </div>

                        @if($isCompleted)
                            <span class="bg-[#BAFFC9] text-emerald-700 font-bold text-xs px-3 py-1 rounded-full border border-emerald-300">
                                Selesai 🎉
                            </span>
                        @elseif($isJoined)
                            <span class="bg-pastel-lavender text-indigo-700 font-bold text-xs px-3 py-1 rounded-full border border-pastel-lavender">
                                Diikuti ⏰
                            </span>
                        @else
                            <span class="bg-gray-100 text-gray-500 font-bold text-xs px-3 py-1 rounded-full">
                                Tersedia
                            </span>
                        @endif
                    </div>

                    <!-- Description -->
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $chall->description }}</p>

                    <!-- Reward Badge Details -->
                    @if($chall->badge)
                        <div class="bg-[#FFFDF6] p-3 rounded-2xl border border-pastel-peach/20 flex items-center gap-3">
                            <span class="text-2xl">🏅</span>
                            <div>
                                <span class="text-xs font-bold text-amber-600 block">HADIAH LENCANA:</span>
                                <span class="text-sm font-semibold text-gray-700">{{ $chall->badge->name }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Progress Tracking -->
                    @if($isJoined)
                        <div class="space-y-2 pt-2">
                            <div class="flex justify-between text-xs font-bold text-gray-500">
                                <span>Progres Waktu Fokus</span>
                                <span>{{ number_format($userChall->progress_hours, 2) }} / {{ $chall->target_hours }} Jam ({{ $percent }}%)</span>
                            </div>
                            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                                <div class="h-full bg-pastel-mint rounded-full transition-all duration-500" style="width: {{ $percent }}%;"></div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Footer button action -->
                <div class="mt-6 pt-4 border-t border-gray-100 relative z-10">
                    @if($isJoined)
                        <button disabled 
                            class="w-full bg-gray-100 text-gray-400 font-bold px-4 py-2.5 rounded-xl text-sm cursor-not-allowed">
                            {{ $isCompleted ? '✓ Tantangan Selesai' : '⏳ Terus Berjuang!' }}
                        </button>
                    @else
                        <button wire:click="joinChallenge({{ $chall->id }})" 
                            class="w-full bg-[#B5E3F7] hover:bg-[#97d4f2] text-sky-800 font-bold px-4 py-2.5 rounded-xl text-sm transition duration-150">
                            🚀 Ikuti Tantangan
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
