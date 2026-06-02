<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChallengeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badge = \App\Models\Badge::where('name', 'Penakluk Tantangan')->first();
        
        $challenges = [
            [
                'title' => 'Belajar 20 Jam/Minggu',
                'description' => 'Tantangan belajar atau bekerja dengan fokus penuh selama 20 jam dalam satu minggu.',
                'target_hours' => 20,
                'duration_weeks' => 1,
                'badge_id' => $badge ? $badge->id : null,
                'start_date' => now()->startOfWeek(),
                'end_date' => now()->startOfWeek()->addWeeks(1)->subDay(),
            ],
            [
                'title' => 'Fokus Konsisten Bulanan',
                'description' => 'Tantangan menjaga produktivitas dengan total 50 jam fokus selama sebulan.',
                'target_hours' => 50,
                'duration_weeks' => 4,
                'badge_id' => $badge ? $badge->id : null,
                'start_date' => now()->startOfMonth(),
                'end_date' => now()->endOfMonth(),
            ]
        ];

        foreach ($challenges as $chall) {
            \App\Models\Challenge::firstOrCreate(['title' => $chall['title']], $chall);
        }
    }
}
