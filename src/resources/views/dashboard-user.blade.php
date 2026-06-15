@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
    
    <!-- Home / Beranda Tab -->
    <div x-show="activeTab === 'home'" x-transition.fade.duration.200ms>
        @livewire('dashboard-home')
    </div>

    <!-- Tab Contents (Livewire Components) -->
    <div x-show="activeTab === 'tasks'" style="display: none;" x-transition.fade.duration.200ms>
        @livewire('task-manager')
    </div>

    <div x-show="activeTab === 'pomodoro'" style="display: none;" x-transition.fade.duration.200ms>
        @livewire('pomodoro-timer')
    </div>

    <div x-show="activeTab === 'challenges'" style="display: none;" x-transition.fade.duration.200ms>
        @livewire('challenge-list')
    </div>

    <div x-show="activeTab === 'badges'" style="display: none;" x-transition.fade.duration.200ms>
        @livewire('user-badge-list')
    </div>

    <div x-show="activeTab === 'statistics'" style="display: none;" x-transition.fade.duration.200ms>
        @livewire('dashboard-statistic')
    </div>

    <div x-show="activeTab === 'notifications'" style="display: none;" x-transition.fade.duration.200ms>
        @livewire('notification-list')
    </div>

</div>
@endsection