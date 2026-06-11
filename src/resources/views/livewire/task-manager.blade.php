<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Kolom Form Tambah/Edit Tugas (1/3) -->
    <div class="bg-white p-6 rounded-3xl border border-pastel-peach/30 shadow-sm h-fit">
        <h3 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            {{ $isEditMode ? '✏️ Edit Tugas' : '✨ Buat Tugas Baru' }}
        </h3>

        @if(session()->has('message'))
            <div class="mb-4 bg-pastel-mint/40 text-emerald-700 border border-pastel-mint p-3 rounded-2xl text-sm font-semibold">
                {{ session('message') }}
            </div>
        @endif

        @if(session()->has('badge_earned'))
            <div class="mb-4 bg-pastel-lavender/50 text-indigo-700 border border-pastel-lavender p-3 rounded-2xl text-sm font-bold animate-bounce">
                {{ session('badge_earned') }}
            </div>
        @endif

        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Judul Tugas</label>
                <input type="text" wire:model="title" placeholder="Belajar Aljabar Linier..." 
                    class="w-full bg-[#FFFDF6] border border-pastel-peach/40 focus:border-pastel-blue rounded-xl p-3 text-sm focus:outline-none transition">
                @error('title') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Deskripsi (Opsional)</label>
                <textarea wire:model="description" placeholder="Bab 3: Matriks dan Determinan" rows="3"
                    class="w-full bg-[#FFFDF6] border border-pastel-peach/40 focus:border-pastel-blue rounded-xl p-3 text-sm focus:outline-none transition"></textarea>
                @error('description') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Progress Tugas (%)</label>
                    <div class="flex items-center gap-3">
                        <input type="range" wire:model.live="progress" min="0" max="100" step="5"
                            class="w-full h-2 bg-[#FFE4E8] rounded-lg appearance-none cursor-pointer accent-[#F46B7E]">
                        <span class="text-sm font-bold text-gray-600 w-10 text-right">{{ $progress ?? 0 }}%</span>
                    </div>
                    @error('progress') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Prioritas</label>
                    <select wire:model="priority" 
                        class="w-full bg-[#FFFDF6] border border-pastel-peach/40 focus:border-pastel-blue rounded-xl p-3 text-sm focus:outline-none transition">
                        <option value="low">Rendah (Hijau)</option>
                        <option value="medium">Sedang (Kuning)</option>
                        <option value="high">Tinggi (Merah)</option>
                    </select>
                    @error('priority') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Tenggat Waktu</label>
                    <input type="date" wire:model="due_date" 
                        class="w-full bg-[#FFFDF6] border border-pastel-peach/40 focus:border-pastel-blue rounded-xl p-3 text-sm focus:outline-none transition">
                    @error('due_date') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Target Tomat (Pomodoro)</label>
                    <input type="number" wire:model="estimated_pomodoros" min="1" max="10" value="1"
                        class="w-full bg-[#FFFDF6] border border-pastel-peach/40 focus:border-pastel-blue rounded-xl p-3 text-sm focus:outline-none transition">
                    @error('estimated_pomodoros') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="flex gap-2 pt-2">
                <button type="submit" class="flex-grow bg-[#B5E3F7] hover:bg-[#97d4f2] text-sky-800 font-bold px-4 py-3 rounded-xl shadow-sm text-sm transition-all duration-200">
                    {{ $isEditMode ? '💾 Perbarui' : '➕ Tambahkan' }}
                </button>
                @if($isEditMode)
                    <button type="button" wire:click="resetForm" class="bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold px-4 py-3 rounded-xl text-sm transition-all duration-200">
                        Batal
                    </button>
                @endif
            </div>
        </form>
    </div>

    <!-- Kolom Daftar Tugas (2/3) -->
    <div class="lg:col-span-2 space-y-4">
        <div class="bg-white p-6 rounded-3xl border border-pastel-peach/30 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-gray-800">📋 Daftar Tugas</h3>
                <span class="text-xs bg-gray-100 text-gray-500 font-bold px-3 py-1 rounded-full">
                    Total: {{ count($tasks) }} Tugas
                </span>
            </div>

            @if(count($tasks) === 0)
                <div class="text-center py-12">
                    <span class="text-5xl">🌸</span>
                    <h4 class="font-bold text-gray-500 mt-4">Belum ada tugas dibuat</h4>
                    <p class="text-gray-400 text-sm mt-1">Buat tugas pertamamu di form sebelah kiri!</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($tasks as $task)
                        @php
                            // Tentukan warna prioritas
                            $priorityColor = match($task->priority) {
                                'high' => 'bg-[#FFB3BA]/40 text-[#D04D54] border border-[#FFD1DC]',
                                'medium' => 'bg-[#FFF5BA]/40 text-[#B89830] border border-[#FFFFBA]',
                                'low' => 'bg-[#BAFFC9]/40 text-[#3C8A53] border border-[#C1E1C1]',
                                default => 'bg-gray-100 text-gray-600',
                            };
                            
                            $progressVal = $task->progress ?? 0;
                            $progressColor = $progressVal == 100 ? 'bg-emerald-400' : ($progressVal >= 50 ? 'bg-blue-400' : 'bg-[#F46B7E]');
                        @endphp
                        
                        <div class="p-5 rounded-2xl border border-gray-100 shadow-sm hover:shadow transition-all duration-200 bg-white flex flex-col md:flex-row md:items-center justify-between gap-4 {{ $task->status === 'completed' ? 'opacity-65' : '' }}">
                            <div class="flex items-start gap-4 flex-grow">
                                <!-- Checkbox Status -->
                                <button wire:click="toggleStatus({{ $task->id }})" class="mt-1 focus:outline-none flex-shrink-0">
                                    @if($task->status === 'completed')
                                        <div class="w-6 h-6 rounded-full bg-pastel-mint border border-emerald-400 flex items-center justify-center text-emerald-600 text-xs">✓</div>
                                    @else
                                        <div class="w-6 h-6 rounded-full border border-gray-300 hover:border-pastel-blue transition"></div>
                                    @endif
                                </button>

                                <div class="space-y-1">
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="font-bold text-gray-800 text-base {{ $task->status === 'completed' ? 'line-through text-gray-400' : '' }}">
                                            {{ $task->title }}
                                        </span>
                                        <span class="text-xs px-2.5 py-0.5 rounded-full font-bold uppercase {{ $priorityColor }}">
                                            {{ $task->priority === 'high' ? 'Penting' : ($task->priority === 'medium' ? 'Sedang' : 'Santai') }}
                                        </span>
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-500">{{ $task->description ?: 'Tidak ada deskripsi.' }}</p>
                                    
                                    <!-- Progress Bar -->
                                    <div class="pt-2 pb-1 w-full max-w-xs">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-[10px] font-bold text-gray-400">Progress</span>
                                            <span class="text-[10px] font-bold text-gray-600">{{ $progressVal }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-100 rounded-full h-1.5">
                                            <div class="{{ $progressColor }} h-1.5 rounded-full transition-all duration-300" style="width: {{ $progressVal }}%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center gap-4 text-xs font-bold text-gray-400 pt-1">
                                        <!-- Est Pomodoros tomato icons -->
                                        <span class="flex items-center gap-1">
                                            🍅 {{ $task->completed_pomodoros }} / {{ $task->estimated_pomodoros }} Tomat
                                        </span>

                                        @if($task->due_date)
                                            <span class="flex items-center gap-1 {{ $task->due_date->isPast() && $task->status !== 'completed' ? 'text-red-400 font-bold' : '' }}">
                                                📅 {{ $task->due_date->format('d M Y') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center md:justify-end gap-2 border-t md:border-t-0 pt-2 md:pt-0">
                                @if($task->due_date && $task->status !== 'completed')
                                    @php
                                        $startDateStr = $task->due_date->format('Ymd');
                                        $endDateStr = $task->due_date->addDay()->format('Ymd');
                                        $calUrl = "https://calendar.google.com/calendar/render?action=TEMPLATE&text=" . urlencode($task->title) . "&details=" . urlencode($task->description ?: '') . "&dates=" . $startDateStr . "/" . $endDateStr;
                                    @endphp
                                    <a href="{{ $calUrl }}" target="_blank" title="Sinkron ke Google Calendar" 
                                        class="bg-pastel-blue/30 text-sky-700 hover:bg-pastel-blue/60 p-2.5 rounded-xl text-xs font-bold transition flex items-center gap-1">
                                        🗓️ +Google Cal
                                    </a>
                                @endif
                                
                                <button wire:click="edit({{ $task->id }})" class="p-2.5 rounded-xl border border-gray-100 hover:bg-gray-50 transition text-blue-500 font-bold text-sm">
                                    ✏️ Edit
                                </button>
                                <button wire:click="delete({{ $task->id }})" class="p-2.5 rounded-xl border border-gray-100 hover:bg-gray-50 transition text-red-400 font-bold text-sm">
                                    🗑️ Hapus
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>