<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Insight;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class InsightSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Create a user with random data
        $user = User::firstOrCreate([
            'email' => 'support@ekilie.com',
        ], [
            'name' => "Sasi W Sasi",
            'password' => bcrypt('tachy2004'),
        ]);

        $categories = Category::all();
        $tags = Tag::all();

        foreach ($categories as $category) {
            foreach (range(1, 5) as $index) {
                $insight = Insight::create([
                    'title' => $faker->sentence(6),
                    'content' => '<p>' . implode('</p><p>', $faker->paragraphs(3)) . '</p>', // Generate random paragraphs
                    'slug' => Str::slug($faker->sentence(3)) . '-' . uniqid(),
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                ]);

                $insight->tags()->attach($tags->random(rand(1, 3))->pluck('id')->toArray());

                // Add comments to each insight with dynamic data
                Comment::create([
                    'comment' => $faker->sentence(),
                    'user_id' => $user->id,
                    'insight_id' => $insight->id,
                ]);
            }
        }
    }
}
