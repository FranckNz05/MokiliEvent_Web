<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        // Comments for blogs
        Blog::all()->each(function ($blog) use ($users) {
            $commentCount = rand(0, 10);
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'commentable_id' => $blog->id,
                    'commentable_type' => Blog::class,
                    'content' => fake()->paragraph(),
                    'is_approved' => rand(0, 1)
                ]);
            }
        });

        // Comments for events
        Event::all()->each(function ($event) use ($users) {
            $commentCount = rand(0, 15);
            for ($i = 0; $i < $commentCount; $i++) {
                Comment::create([
                    'user_id' => $users->random()->id,
                    'commentable_id' => $event->id,
                    'commentable_type' => Event::class,
                    'content' => fake()->paragraph(),
                    'is_approved' => rand(0, 1)
                ]);
            }
        });
    }
}
