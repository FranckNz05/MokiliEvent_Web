<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Concerts & Music',
            'Conferences',
            'Sports & Fitness',
            'Theater & Shows',
            'Art & Culture',
            'Food & Drink',
            'Business & Professional',
            'Community & Social',
            'Education & Learning',
            'Fashion & Beauty',
            'Film & Media',
            'Health & Wellness',
            'Science & Technology',
            'Travel & Outdoor',
            'Charity & Causes'
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => fake()->sentence(),
                'status' => 'active'
            ]);
        }
    }
}
