<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckChallengeProgress extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-challenge-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks ongoing user challenges and marks them as failed if their end date has passed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking challenge progress...');

        $expiredChallenges = \App\Models\UserChallenge::where('status', 'ongoing')
            ->whereHas('challenge', function ($query) {
                $query->where('end_date', '<', now()->startOfDay());
            })
            ->get();

        $count = 0;
        foreach ($expiredChallenges as $userChallenge) {
            $userChallenge->update([
                'status' => 'failed'
            ]);
            $count++;
        }

        $this->info("Successfully checked challenges. Marked {$count} challenges as failed.");
    }
}
