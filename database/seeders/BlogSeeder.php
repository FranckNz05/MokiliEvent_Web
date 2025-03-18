<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role(['admin', 'super-admin'])->get();
        $tags = Tag::all();

        // Create 30 blog posts
        for ($i = 0; $i < 30; $i++) {
            $title = fake()->unique()->sentence();
            $blog = Blog::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => fake()->paragraphs(5, true),
                'excerpt' => fake()->paragraph(),
                'user_id' => $users->random()->id,
                'featured_image' => null,
                'status' => fake()->randomElement(['draft', 'published']),
                'visibility' => fake()->randomElement(['public', 'private']),
                'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
                'views_count' => 0,
                'likes_count' => 0,
                'comments_count' => 0,
                'seo_title' => $title,
                'seo_description' => fake()->paragraph(),
                'seo_keywords' => implode(', ', fake()->words(5)),
                'meta_data' => json_encode([
                    'reading_time' => rand(3, 15) . ' min',
                    'author_bio' => fake()->paragraph()
                ])
            ]);

            // Attach 2-4 random tags to each blog
            $blog->tags()->attach(
                $tags->random(rand(2, 4))->pluck('id')->toArray()
            );
        }
    }
}
