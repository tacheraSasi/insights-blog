<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        $tags = [
            ['name' => 'JavaScript', 'color' => '#F7DF1E', 'description' => 'JavaScript programming language'],
            ['name' => 'PHP', 'color' => '#777BB4', 'description' => 'PHP server-side programming'],
            ['name' => 'Laravel', 'color' => '#FF2D20', 'description' => 'Laravel PHP framework'],
            ['name' => 'React', 'color' => '#61DAFB', 'description' => 'React JavaScript library'],
            ['name' => 'Vue.js', 'color' => '#4FC08D', 'description' => 'Vue.js JavaScript framework'],
            ['name' => 'Python', 'color' => '#3776AB', 'description' => 'Python programming language'],
            ['name' => 'Node.js', 'color' => '#339933', 'description' => 'Node.js runtime environment'],
            ['name' => 'API', 'color' => '#FF6B6B', 'description' => 'Application Programming Interface'],
            ['name' => 'Database', 'color' => '#4ECDC4', 'description' => 'Database design and management'],
            ['name' => 'DevOps', 'color' => '#FF8C00', 'description' => 'Development and Operations'],
            ['name' => 'Tutorial', 'color' => '#9B59B6', 'description' => 'Step-by-step tutorials'],
            ['name' => 'Tips', 'color' => '#2ECC71', 'description' => 'Programming tips and tricks'],
            ['name' => 'Best Practices', 'color' => '#E74C3C', 'description' => 'Industry best practices'],
            ['name' => 'Performance', 'color' => '#F39C12', 'description' => 'Performance optimization'],
            ['name' => 'Security', 'color' => '#8E44AD', 'description' => 'Security and vulnerability topics'],
            ['name' => 'Life Style', 'color' => '#3498DB', 'description' => 'Personal life style choices'],
            ['name' => 'Mental Health', 'color' => '#27AE60', 'description' => 'Mental health and well-being'],
            ['name' => 'Relationships', 'color' => '#E74C3C', 'description' => 'Building and maintaining relationships'],
            ['name' => 'Dating', 'color' => '#9B59B6', 'description' => 'Dating and finding a partner'],
            ['name' => 'Love Stories', 'color' => '#F39C12', 'description' => 'Heartwarming love stories']
        ];

        foreach ($tags as $tagData) {
            Tag::firstOrCreate(
                ['name' => $tagData['name']],
                $tagData
            );
        }
    }
}
