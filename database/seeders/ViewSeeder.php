<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Event;
use App\Models\View;
use Illuminate\Database\Seeder;

class ViewSeeder extends Seeder
{
    public function run(): void
    {
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
            'Mozilla/5.0 (iPad; CPU OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Mobile/15E148 Safari/604.1'
        ];

        // Views for blogs
        Blog::all()->each(function ($blog) use ($userAgents) {
            $viewCount = rand(10, 100);
            for ($i = 0; $i < $viewCount; $i++) {
                View::create([
                    'viewable_id' => $blog->id,
                    'viewable_type' => Blog::class,
                    'ip_address' => fake()->ipv4(),
                    'user_agent' => $userAgents[array_rand($userAgents)],
                    'created_at' => fake()->dateTimeBetween('-6 months', 'now')
                ]);
            }
        });

        // Views for events
        Event::all()->each(function ($event) use ($userAgents) {
            $viewCount = rand(20, 200);
            for ($i = 0; $i < $viewCount; $i++) {
                View::create([
                    'viewable_id' => $event->id,
                    'viewable_type' => Event::class,
                    'ip_address' => fake()->ipv4(),
                    'user_agent' => $userAgents[array_rand($userAgents)],
                    'created_at' => fake()->dateTimeBetween('-6 months', 'now')
                ]);
            }
        });
    }
}
