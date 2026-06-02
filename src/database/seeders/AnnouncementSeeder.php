<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Announcement::firstOrCreate(
            ['title' => 'Selamat Datang di PomoTasky!'],
            [
                'content' => 'Selamat datang di Sistem Manajemen Tugas & Pomodoro Timer PomoTasky. Gunakan sistem ini untuk melacak tugas harianmu, jalankan timer Pomodoro untuk fokus optimal, dapatkan berbagai macam badge, dan ikuti tantangan yang ada untuk memacu produktivitasmu!',
                'is_active' => true,
                'published_at' => now(),
            ]
        );
    }
}
