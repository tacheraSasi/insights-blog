<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'description' => 'Articles related to technology, programming, and gadgets.'],
            ['name' => 'Life', 'description' => 'Articles about life, personal development, and well-being.'],
            ['name' => 'Love', 'description' => 'Articles about love, relationships, and dating.'],
            ['name' => 'Software Engineering', 'description' => 'In-depth articles on software engineering principles and practices.'],
            ['name' => 'Web Development', 'description' => 'Tutorials and guides on web development technologies.'],
            ['name' => 'Mobile Development', 'description' => 'Tutorials and guides on mobile development technologies.'],
            ['name' => 'Artificial Intelligence', 'description' => 'Exploring the world of AI and machine learning.'],
            ['name' => 'Cybersecurity', 'description' => 'Insights into cybersecurity threats and best practices.'],
            ['name' => 'Productivity', 'description' => 'Tips and tricks to boost your productivity.'],
            ['name' => 'Career Development', 'description' => 'Guidance on navigating your career path in the tech industry.'],
            ['name' => 'Personal Finance', 'description' => 'Managing your finances for a better future.'],
            ['name' => 'Health & Fitness', 'description' => 'Living a healthy and active lifestyle.'],
            ['name' => 'Travel', 'description' => 'Exploring new places and cultures.'],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['name' => $categoryData['name']],
                [
                    'slug' => Str::slug($categoryData['name']),
                    'description' => $categoryData['description'],
                ]
            );
        }
    }
}
