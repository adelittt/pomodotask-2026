<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Challenge;
use App\Models\UserChallenge;

class ChallengeList extends Component
{
    public function render()
    {
        $userId = auth()->id();
        
        // Ambil semua tantangan dari database
        $challenges = Challenge::with('badge')->latest()->get();
        
        // Ambil data keikutsertaan user
        $userChallenges = UserChallenge::where('user_id', $userId)
            ->get()
            ->keyBy('challenge_id');

        return view('livewire.challenge-list', compact('challenges', 'userChallenges'));
    }

    public function joinChallenge($challengeId)
    {
        $userId = auth()->id();

        // Pastikan belum bergabung sebelumnya
        $exists = UserChallenge::where('user_id', $userId)
            ->where('challenge_id', $challengeId)
            ->exists();

        if (!$exists) {
            UserChallenge::create([
                'user_id' => $userId,
                'challenge_id' => $challengeId,
                'status' => 'ongoing',
                'progress_hours' => 0.00,
                'joined_at' => now(),
            ]);

            session()->flash('message', 'Kamu berhasil bergabung dalam tantangan! Mulai jalankan Pomodoro untuk mengisi progresmu 🚀');
        }
    }
}
