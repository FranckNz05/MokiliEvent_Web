<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organizer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizerSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 organizers with their corresponding users
        for ($i = 0; $i < 10; $i++) {
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();
            $username = Str::slug($firstName . $lastName . rand(1, 999));
            $organizationName = fake()->company();
            
            // Create user first
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username,
                'email' => fake()->unique()->safeEmail(),
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'phone' => fake()->e164PhoneNumber(),
                'bio' => fake()->paragraph(),
                'status' => 'active',
                'avatar' => null,
                'cover_image' => null,
                'address' => fake()->address(),
                'city' => fake()->city(),
                'country' => fake()->country(),
                'social_links' => json_encode([
                    'facebook' => 'https://facebook.com/' . $username,
                    'twitter' => 'https://twitter.com/' . $username,
                    'instagram' => 'https://instagram.com/' . $username,
                    'linkedin' => 'https://linkedin.com/in/' . $username
                ])
            ]);
            
            $user->assignRole('organizer');

            // Create organizer profile
            Organizer::create([
                'user_id' => $user->id,
                'organization_name' => $organizationName,
                'slug' => Str::slug($organizationName),
                'description' => fake()->paragraphs(2, true),
                'website' => fake()->url(),
                'email' => fake()->companyEmail(),
                'phone' => fake()->phoneNumber(),
                'address' => fake()->address(),
                'city' => fake()->city(),
                'country' => fake()->country(),
                'logo' => null,
                'cover_image' => null,
                'status' => 'active',
                'verification_status' => fake()->randomElement(['pending', 'verified', 'rejected']),
                'social_links' => json_encode([
                    'facebook' => 'https://facebook.com/' . Str::slug($organizationName),
                    'twitter' => 'https://twitter.com/' . Str::slug($organizationName),
                    'instagram' => 'https://instagram.com/' . Str::slug($organizationName),
                    'linkedin' => 'https://linkedin.com/company/' . Str::slug($organizationName)
                ]),
                'settings' => json_encode([
                    'notifications' => [
                        'email' => true,
                        'push' => true
                    ],
                    'privacy' => [
                        'show_email' => false,
                        'show_phone' => true
                    ]
                ])
            ]);
        }
    }
}
