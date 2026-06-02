<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Belajar', 'slug' => 'belajar', 'color' => '#B5E3F7'], // pastel blue
            ['name' => 'Pekerjaan', 'slug' => 'pekerjaan', 'color' => '#FFD1DC'], // pastel pink
            ['name' => 'Kesehatan', 'slug' => 'kesehatan', 'color' => '#C1E1C1'], // pastel mint
            ['name' => 'Hobi', 'slug' => 'hobi', 'color' => '#E6E6FA'], // pastel lavender
            ['name' => 'Lain-lain', 'slug' => 'lain-lain', 'color' => '#FFF5BA'], // pastel yellow
        ];

        foreach ($categories as $cat) {
            \App\Models\Category::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
