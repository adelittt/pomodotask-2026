<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\PomodoroSession;
use App\Models\UserChallenge;
use App\Traits\AwardsBadges;
use Livewire\Attributes\On;

class DashboardHome extends Component
{
    use AwardsBadges;

    public $activeTaskId = '';

    #[On('taskUpdated')]
    #[On('sessionCompleted')]
    public function render()
    {
        $userId = auth()->id();

        // 1. Hitung Tugas Selesai
        $tasksCompleted = Task::where('user_id', $userId)->where('status', 'completed')->count();
        
        // 2. Hitung Waktu Fokus dan Pomodoro
        $totalPomodoros = Task::where('user_id', $userId)->sum('completed_pomodoros');
        
        // Atur waktu berdasarkan total sesi dari pomodoro session atau dari task.
        // Di dashboard mockup pakai total pomodoro task. Kita gunakan data aktual dari PomodoroSession.
        $totalFocusMinutes = PomodoroSession::where('user_id', $userId)->where('type', 'work')->sum('duration');
        $waktuFokusJam = floor($totalFocusMinutes / 60);
        $waktuFokusMenit = $totalFocusMinutes % 60;
        $totalPomodorosReal = PomodoroSession::where('user_id', $userId)->where('type', 'work')->count();
        
        // 3. Tugas Mendatang
        $upcomingTasks = Task::where('user_id', $userId)
            ->where('status', '!=', 'completed')
            ->orderBy('due_date', 'asc')
            ->take(3)
            ->get();

        // 4. Semua tugas aktif (untuk dropdown timer)
        $tasks = Task::where('user_id', $userId)
            ->where('status', 'pending')
            ->latest()
            ->get();

        // 5. Data Fokus Mingguan (Senin-Minggu)
        $weeklyFocus = [];
        $startOfWeek = now()->startOfWeek(); // Senin
        
        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $dayNames = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
            $dayName = $dayNames[$i];
            
            $duration = PomodoroSession::where('user_id', $userId)
                ->whereDate('completed_at', $date->format('Y-m-d'))
                ->sum('duration'); // dalam menit
                
            $weeklyFocus[] = [
                'day' => $dayName,
                'duration' => $duration,
                // Maksimal 8 jam = 480 menit di chart (karena Y axis max 8h)
                'percentage' => min(100, ($duration > 0 ? ($duration / 480) * 100 : 5)) // minimal 5% agar bar terlihat sedikit
            ];
        }

        return view('livewire.dashboard-home', compact(
            'tasksCompleted', 
            'totalPomodorosReal', 
            'waktuFokusJam', 
            'waktuFokusMenit', 
            'upcomingTasks',
            'tasks',
            'weeklyFocus'
        ));
    }

    #[On('savePomodoroSession')]
    public function saveSession($taskId, $duration, $type)
    {
        $userId = auth()->id();
        
        $isNumericTask = is_numeric($taskId) && $taskId > 0;

        // 1. Simpan sesi Pomodoro ke database
        PomodoroSession::create([
            'user_id' => $userId,
            'task_id' => $isNumericTask ? $taskId : null,
            'category' => !$isNumericTask && $taskId ? $taskId : null,
            'duration' => $duration, // dalam menit
            'type' => $type,
            'completed_at' => now(),
        ]);

        // 2. Update task
        if ($isNumericTask) {
            $task = Task::where('user_id', $userId)->find($taskId);
            if ($task) {
                $task->increment('completed_pomodoros');
                
                if ($task->completed_pomodoros >= $task->estimated_pomodoros) {
                    session()->flash('timer_message', "Sesi disimpan! Target tomat untuk tugas '{$task->title}' telah tercapai 🍅");
                }
            }
        }

        // 3. Update progres tantangan aktif
        if ($type === 'work') {
            $hoursEarned = $duration / 60;
            
            $userChallenges = UserChallenge::where('user_id', $userId)
                ->where('status', 'ongoing')
                ->with('challenge')
                ->get();

            foreach ($userChallenges as $uc) {
                $challenge = $uc->challenge;
                $uc->progress_hours += $hoursEarned;

                if ($uc->progress_hours >= $challenge->target_hours) {
                    $uc->status = 'completed';
                    $uc->completed_at = now();
                    
                    if ($challenge->badge_id) {
                        $earnedBadgeIds = auth()->user()->badges()->pluck('badges.id')->toArray();
                        if (!in_array($challenge->badge_id, $earnedBadgeIds)) {
                            auth()->user()->badges()->attach($challenge->badge_id, ['earned_at' => now()]);
                            session()->flash('badge_earned', "🎉 Selamat! Kamu menyelesaikan Tantangan '{$challenge->title}' dan mendapatkan lencana hadiah!");
                        }
                    }
                }
                
                $uc->save();
            }
        }

        // 4. Evaluasi perolehan lencana umum
        $this->checkAndAwardBadges();

        if (!session()->has('timer_message') && !session()->has('badge_earned')) {
            session()->flash('message', 'Sesi Pomodoro berhasil disimpan! Kerja bagus 🌟');
        }

        // Dispatch event untuk update chart/stats
        $this->dispatch('sessionCompleted');
    }

    public function toggleStatus($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $task->status = $task->status === 'completed' ? 'pending' : 'completed';
        
        // Asumsi jika selesai, progress jadi 100%
        if ($task->status === 'completed') {
            $task->progress = 100;
        }

        $task->save();

        if ($task->status === 'completed') {
            $this->checkAndAwardBadges();
        }

        session()->flash('message', $task->status === 'completed' ? 'Tugas diselesaikan! 🎉' : 'Tugas dibuka kembali.');
        $this->dispatch('taskUpdated');
    }
}
