<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\PomodoroSession;
use App\Models\UserChallenge;
use App\Traits\AwardsBadges;

class PomodoroTimer extends Component
{
    use AwardsBadges;

    public $activeTaskId = '';

    public function render()
    {
        // Ambil tugas pending milik user
        $tasks = Task::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('livewire.pomodoro-timer', compact('tasks'));
    }

}
