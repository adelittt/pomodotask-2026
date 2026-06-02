<?php

namespace App\Traits;

use App\Models\Badge;
use App\Models\Task;
use App\Models\PomodoroSession;
use App\Models\UserChallenge;

trait AwardsBadges
{
    public function checkAndAwardBadges()
    {
        $user = auth()->user();
        if (!$user) return;

        // 1. Dapatkan badge yang belum didapat oleh user
        $earnedBadgeIds = $user->badges()->pluck('badges.id')->toArray();
        $availableBadges = Badge::whereNotIn('id', $earnedBadgeIds)->get();

        // 2. Hitung pencapaian user
        $pomodoroCount = PomodoroSession::where('user_id', $user->id)->where('type', 'work')->count();
        $tasksCompletedCount = Task::where('user_id', $user->id)->where('status', 'completed')->count();
        $challengesCompletedCount = UserChallenge::where('user_id', $user->id)->where('status', 'completed')->count();

        foreach ($availableBadges as $badge) {
            $earned = false;

            if ($badge->rule_type === 'pomodoro_count' && $pomodoroCount >= $badge->rule_value) {
                $earned = true;
            } elseif ($badge->rule_type === 'task_completed' && $tasksCompletedCount >= $badge->rule_value) {
                $earned = true;
            } elseif ($badge->rule_type === 'challenge_completed' && $challengesCompletedCount >= $badge->rule_value) {
                $earned = true;
            }

            if ($earned) {
                $user->badges()->attach($badge->id, ['earned_at' => now()]);
                session()->flash('badge_earned', "🎉 Selamat! Kamu mendapatkan lencana baru: {$badge->name}!");
            }
        }
    }
}
