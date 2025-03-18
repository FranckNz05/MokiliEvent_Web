<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Music',
            'Technology',
            'Business',
            'Art',
            'Food',
            'Sports',
            'Fashion',
            'Education',
            'Entertainment',
            'Health',
            'Lifestyle',
            'Travel',
            'Science',
            'Culture',
            'Gaming'
        ];

        foreach ($tags as $tagName) {
            Tag::create([
                'name' => $tagName,
                'slug' => Str::slug($tagName),
                'description' => fake()->sentence()
            ]);
        }
    }
}
