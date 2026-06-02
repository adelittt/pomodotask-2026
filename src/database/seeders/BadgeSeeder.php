<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name' => 'Pemula Fokus',
                'description' => 'Menyelesaikan 1 sesi Pomodoro pertama.',
                'icon' => 'heroicon-o-fire',
                'rule_type' => 'pomodoro_count',
                'rule_value' => 1
            ],
            [
                'name' => 'Master Fokus',
                'description' => 'Menyelesaikan 10 sesi Pomodoro.',
                'icon' => 'heroicon-o-sparkles',
                'rule_type' => 'pomodoro_count',
                'rule_value' => 10
            ],
            [
                'name' => 'Pejuang Tugas',
                'description' => 'Menyelesaikan 5 tugas pertama.',
                'icon' => 'heroicon-o-check-circle',
                'rule_type' => 'task_completed',
                'rule_value' => 5
            ],
            [
                'name' => 'Penakluk Tantangan',
                'description' => 'Menyelesaikan 1 tantangan.',
                'icon' => 'heroicon-o-trophy',
                'rule_type' => 'challenge_completed',
                'rule_value' => 1
            ]
        ];

        foreach ($badges as $badge) {
            \App\Models\Badge::firstOrCreate(['name' => $badge['name']], $badge);
        }
    }
}
