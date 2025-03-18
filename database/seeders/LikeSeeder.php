<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Like;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        
        // Likes for blogs
        Blog::all()->each(function ($blog) use ($users) {
            // Each blog gets random number of likes
            $likeCount = rand(0, 20);
            $randomUsers = $users->random($likeCount);
            
            foreach ($randomUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_id' => $blog->id,
                    'likeable_type' => Blog::class
                ]);
            }
        });

        // Likes for events
        Event::all()->each(function ($event) use ($users) {
            // Each event gets random number of likes
            $likeCount = rand(0, 30);
            $randomUsers = $users->random($likeCount);
            
            foreach ($randomUsers as $user) {
                Like::create([
                    'user_id' => $user->id,
                    'likeable_id' => $event->id,
                    'likeable_type' => Event::class
                ]);
            }
        });
    }
}
