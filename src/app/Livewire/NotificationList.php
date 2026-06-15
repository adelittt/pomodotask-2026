<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\Challenge;
use App\Models\Badge;
use Carbon\Carbon;

class NotificationList extends Component
{
    public function getNotificationsProperty()
    {
        $notifications = collect();

        if (!auth()->check()) {
            return $notifications;
        }

        // 1. Deadline tugas H-2
        $tasks = Task::where('user_id', auth()->id())
            ->where('status', '!=', 'completed')
            ->whereNotNull('due_date')
            ->whereBetween('due_date', [Carbon::now()->startOfDay(), Carbon::now()->addDays(2)->endOfDay()])
            ->get();

        foreach ($tasks as $task) {
            $daysLeft = Carbon::now()->startOfDay()->diffInDays(Carbon::parse($task->due_date)->startOfDay(), false);
            $timeText = $daysLeft == 0 ? 'Hari ini' : ($daysLeft == 1 ? 'Besok' : 'H-2');
            
            $notifications->push([
                'id' => 'task_'.$task->id,
                'type' => 'task',
                'title' => 'Deadline Mendekat!',
                'message' => "Tugas '{$task->title}' akan deadline {$timeText}.",
                'icon' => '⏰',
                'color' => 'text-red-500',
                'bg' => 'bg-red-50',
                'time' => $task->due_date,
                'created_at' => Carbon::now()
            ]);
        }

        // 2. New Challenges from Admin (last 3 days)
        $challenges = Challenge::where('created_at', '>=', Carbon::now()->subDays(3))->get();
        foreach ($challenges as $challenge) {
            $notifications->push([
                'id' => 'challenge_'.$challenge->id,
                'type' => 'challenge',
                'title' => 'Tantangan Baru!',
                'message' => "Admin menambahkan tantangan: '{$challenge->title}'. Yuk ikutan!",
                'icon' => '🎯',
                'color' => 'text-blue-500',
                'bg' => 'bg-blue-50',
                'time' => $challenge->created_at,
                'created_at' => $challenge->created_at
            ]);
        }

        // 3. New Badges from Admin (last 3 days)
        $badges = Badge::where('created_at', '>=', Carbon::now()->subDays(3))->get();
        foreach ($badges as $badge) {
            $notifications->push([
                'id' => 'badge_'.$badge->id,
                'type' => 'badge',
                'title' => 'Badge Baru Tersedia!',
                'message' => "Admin menambahkan badge: '{$badge->name}'. Kumpulkan sekarang!",
                'icon' => '🏆',
                'color' => 'text-yellow-500',
                'bg' => 'bg-yellow-50',
                'time' => $badge->created_at,
                'created_at' => $badge->created_at
            ]);
        }

        return $notifications->sortByDesc('created_at')->values();
    }

    public function render()
    {
        return view('livewire.notification-list', [
            'notifications' => $this->notifications
        ]);
    }
}
