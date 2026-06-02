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

    public function saveSession($taskId, $duration, $type)
    {
        $userId = auth()->id();

        // 1. Simpan sesi Pomodoro ke database
        $session = PomodoroSession::create([
            'user_id' => $userId,
            'task_id' => $taskId ?: null,
            'duration' => $duration, // dalam menit
            'type' => $type,
            'completed_at' => now(),
        ]);

        // 2. Jika dikaitkan dengan tugas, tambahkan jumlah pomodoro selesai pada tugas tersebut
        if ($taskId) {
            $task = Task::where('user_id', $userId)->find($taskId);
            if ($task) {
                $task->increment('completed_pomodoros');
                
                // Jika sudah mencapai target estimasi tomat, tugas otomatis diselesaikan?
                // Lebih baik user menyelesaikannya sendiri, namun kita beri notifikasi jika target tercapai
                if ($task->completed_pomodoros >= $task->estimated_pomodoros) {
                    session()->flash('timer_message', "Sesi disimpan! Target tomat untuk tugas '{$task->title}' telah tercapai 🍅");
                }
            }
        }

        // 3. Update progres tantangan aktif (Challenges) jika bertipe 'work'
        if ($type === 'work') {
            $hoursEarned = $duration / 60; // konversi menit ke jam
            
            // Ambil semua tantangan berjalan milik user
            $userChallenges = UserChallenge::where('user_id', $userId)
                ->where('status', 'ongoing')
                ->with('challenge')
                ->get();

            foreach ($userChallenges as $uc) {
                $challenge = $uc->challenge;
                
                // Tambahkan progres jam fokus
                $uc->progress_hours += $hoursEarned;

                // Cek jika target tercapai
                if ($uc->progress_hours >= $challenge->target_hours) {
                    $uc->status = 'completed';
                    $uc->completed_at = now();
                    
                    // Berikan hadiah badge jika ada
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
    }
}
