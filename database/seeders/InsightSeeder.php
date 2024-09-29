<?php
namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Insight;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class InsightSeeder extends Seeder
{
    public function run()
    {
        // Create a user
        $user = User::firstOrCreate([
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
        ], [
            'password' => bcrypt('password'),
        ]);

        // Create some categories ensuring uniqueness
        foreach (range(1, 5) as $index) {
            $name = 'Category ' . $index;
            $category = Category::firstOrCreate([
                'name' => $name,
            ], [
                'slug' => \Illuminate\Support\Str::slug($name) . '-' . uniqid(), // Ensure unique slug
            ]);

            // Create insights with comments and likes
            $insight = Insight::create([
                'title' => 'Sample Insight in ' . $category->name,
                'content' => '<p>This is a rich content example for ' . $category->name . '.</p>',
                'slug' => \Illuminate\Support\Str::slug('Sample Insight in ' . $category->name) . '-' . uniqid(), // Ensure unique slug
                'user_id' => $user->id,
                'category_id' => $category->id,
            ]);

            // Add comments to each insight
            Comment::create([
                'comment' => 'This is a comment on ' . $insight->title,
                'user_id' => $user->id,
                'insight_id' => $insight->id,
            ]);
        }
    }
}
