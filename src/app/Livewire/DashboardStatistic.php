<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\PomodoroSession;
use App\Models\UserBadge;
use App\Models\UserChallenge;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class DashboardStatistic extends Component
{
    #[On('taskUpdated')]
    #[On('sessionCompleted')]
    public function render()
    {
        $userId = auth()->id();

        // 1. Hitung metrik ringkasan
        $totalTasks = Task::where('user_id', $userId)->count();
        $completedTasks = Task::where('user_id', $userId)->where('status', 'completed')->count();
        $pendingTasks = $totalTasks - $completedTasks;

        $totalSessions = PomodoroSession::where('user_id', $userId)->where('type', 'work')->count();
        $totalFocusMinutes = PomodoroSession::where('user_id', $userId)->where('type', 'work')->sum('duration');
        $totalFocusHours = round($totalFocusMinutes / 60, 1);

        $earnedBadges = UserBadge::where('user_id', $userId)->count();
        $activeChallenges = UserChallenge::where('user_id', $userId)->where('status', 'ongoing')->count();

        // 2. Ambil data sesi fokus 7 hari terakhir untuk grafik batang SVG
        $weeklyStats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $dayName = $date->isoFormat('dd'); // e.g. Se, Ra, Ka, Ju, Sa, Mi, Se

            $minutes = PomodoroSession::where('user_id', $userId)
                ->where('type', 'work')
                ->whereDate('completed_at', $dateString)
                ->sum('duration');

            $weeklyStats[] = [
                'day' => $dayName,
                'date' => $date->format('d M'),
                'minutes' => $minutes,
            ];
        }

        // Cari menit maksimum untuk penskalaan grafik
        $maxMinutes = collect($weeklyStats)->max('minutes') ?: 60; // fallback agar pembagian tidak nol
        
        // 3. Riwayat Sesi Pomodoro Terbaru (limit 5)
        $recentSessions = PomodoroSession::where('user_id', $userId)
            ->with('task')
            ->latest('completed_at')
            ->limit(5)
            ->get();

        return view('livewire.dashboard-statistic', compact(
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'totalSessions',
            'totalFocusHours',
            'earnedBadges',
            'activeChallenges',
            'weeklyStats',
            'maxMinutes',
            'recentSessions'
        ));
    }
}
