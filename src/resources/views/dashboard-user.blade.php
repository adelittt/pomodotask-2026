@extends('layouts.app')

@section('content')
<div x-data="{ activeTab: 'tasks' }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header Selamat Datang & Pengumuman Ringkas -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between bg-white p-6 rounded-3xl border border-pastel-peach/20 shadow-sm relative overflow-hidden">
        <div class="absolute -right-16 -top-16 w-32 h-32 bg-pastel-pink/30 rounded-full blur-2xl"></div>
        <div class="absolute -left-16 -bottom-16 w-32 h-32 bg-pastel-blue/30 rounded-full blur-2xl"></div>
        
        <div class="relative z-10">
            <h2 class="text-3xl font-bold text-gray-800">✨ Halo, {{ auth()->user()->name }}!</h2>
            <p class="text-gray-500 mt-1">Hari ini adalah hari yang indah untuk tetap produktif. Pilih tab di bawah ini untuk memulai.</p>
        </div>

        @php
            $latestAnnouncement = \App\Models\Announcement::active()->latest()->first();
        @endphp
        @if($latestAnnouncement)
            <div class="mt-4 md:mt-0 max-w-md bg-pastel-lavender/50 border border-pastel-lavender p-4 rounded-2xl relative z-10">
                <span class="text-xs font-bold text-indigo-500 block mb-1">📢 PENGUMUMAN TERBARU</span>
                <h4 class="font-bold text-sm text-gray-700">{{ $latestAnnouncement->title }}</h4>
                <p class="text-xs text-gray-600 mt-1">{{ strip_tags($latestAnnouncement->content) }}</p>
            </div>
        @endif
    </div>
    
    <!-- Tab Navigation Premium Pastel -->
    <div class="flex flex-wrap gap-2 mb-8 bg-gray-100/50 p-2 rounded-2xl border border-gray-200/50 max-w-max">
        <button 
            @click="activeTab = 'tasks'"
            :class="activeTab === 'tasks' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-200/30'"
            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 ease-in-out flex items-center gap-2">
            📋 Tugas Saya
        </button>
        <button 
            @click="activeTab = 'pomodoro'"
            :class="activeTab === 'pomodoro' ? 'bg-[#FFB3BA]/40 text-[#D04D54] shadow-sm font-extrabold border border-[#FFD1DC]' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-200/30'"
            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 ease-in-out flex items-center gap-2">
            🍅 Pomodoro Timer
        </button>
        <button 
            @click="activeTab = 'challenges'"
            :class="activeTab === 'challenges' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-200/30'"
            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 ease-in-out flex items-center gap-2">
            🏆 Tantangan
        </button>
        <button 
            @click="activeTab = 'badges'"
            :class="activeTab === 'badges' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-200/30'"
            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 ease-in-out flex items-center gap-2">
            🏅 Badge Saya
        </button>
        <button 
            @click="activeTab = 'statistics'"
            :class="activeTab === 'statistics' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-800 hover:bg-gray-200/30'"
            class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all duration-200 ease-in-out flex items-center gap-2">
            📊 Statistik Fokus
        </button>
    </div>

    <!-- Tab Contents -->
    <div class="bg-transparent">
        <div x-show="activeTab === 'tasks'" x-transition.fade.duration.200ms>
            @livewire('task-manager')
        </div>

        <div x-show="activeTab === 'pomodoro'" x-transition.fade.duration.200ms>
            @livewire('pomodoro-timer')
        </div>

        <div x-show="activeTab === 'challenges'" x-transition.fade.duration.200ms>
            @livewire('challenge-list')
        </div>

        <div x-show="activeTab === 'badges'" x-transition.fade.duration.200ms>
            @livewire('user-badge-list')
        </div>

        <div x-show="activeTab === 'statistics'" x-transition.fade.duration.200ms>
            @livewire('dashboard-statistic')
        </div>
    </div>
</div>
@endsection