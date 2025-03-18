<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Category;
use App\Models\Organizer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        $organizers = Organizer::all();

        // Create 50 events
        for ($i = 0; $i < 50; $i++) {
            $startDate = fake()->dateTimeBetween('now', '+6 months');
            $endDate = clone $startDate;
            $endDate->modify('+' . rand(1, 5) . ' days');
            $title = fake()->sentence(6);

            $event = Event::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'description' => fake()->paragraphs(3, true),
                'short_description' => fake()->paragraph(),
                'category_id' => $categories->random()->id,
                'organizer_id' => $organizers->random()->id,
                'featured_image' => null,
                'gallery' => json_encode([]),
                'location' => fake()->address(),
                'venue' => fake()->company() . ' ' . fake()->companySuffix(),
                'city' => fake()->city(),
                'country' => fake()->country(),
                'start_date' => $startDate,
                'end_date' => $endDate,
                'start_time' => fake()->time(),
                'end_time' => fake()->time(),
                'timezone' => 'Africa/Kinshasa',
                'ticket_price' => rand(0, 1) ? rand(10, 200) : 0,
                'ticket_quantity' => rand(50, 1000),
                'tickets_available' => rand(0, 1000),
                'registration_deadline' => fake()->dateTimeBetween('now', $startDate),
                'status' => fake()->randomElement(['draft', 'published', 'cancelled']),
                'visibility' => fake()->randomElement(['public', 'private']),
                'featured' => rand(0, 1),
                'views_count' => 0,
                'likes_count' => 0,
                'comments_count' => 0,
                'website' => fake()->url(),
                'contact_email' => fake()->email(),
                'contact_phone' => fake()->phoneNumber(),
                'age_restriction' => fake()->randomElement([null, '18+', '21+']),
                'dress_code' => fake()->randomElement([null, 'Casual', 'Business Casual', 'Formal']),
                'tags' => json_encode(fake()->words(rand(2, 5))),
                'additional_info' => json_encode([
                    'parking' => fake()->sentence(),
                    'refreshments' => fake()->sentence(),
                    'accessibility' => fake()->sentence()
                ]),
                'seo_title' => $title,
                'seo_description' => fake()->paragraph(),
                'seo_keywords' => implode(', ', fake()->words(5))
            ]);
        }
    }
}
