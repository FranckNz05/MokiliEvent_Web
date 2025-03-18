<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create super admin
        $superAdmin = User::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'username' => 'superadmin',
            'email' => 'superadmin@mokilievent.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'phone' => '+243000000000',
            'bio' => 'Super Administrator of MokiliEvent',
            'status' => 'active',
            'avatar' => null,
            'cover_image' => null,
            'address' => fake()->address(),
            'city' => 'Kinshasa',
            'country' => 'DR Congo',
            'social_links' => json_encode([
                'facebook' => 'https://facebook.com/superadmin',
                'twitter' => 'https://twitter.com/superadmin',
                'instagram' => 'https://instagram.com/superadmin',
                'linkedin' => 'https://linkedin.com/in/superadmin'
            ])
        ]);
        $superAdmin->assignRole('super-admin');

        // Create admin
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'username' => 'admin',
            'email' => 'admin@mokilievent.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'phone' => '+243000000001',
            'bio' => 'Administrator of MokiliEvent',
            'status' => 'active',
            'avatar' => null,
            'cover_image' => null,
            'address' => fake()->address(),
            'city' => 'Kinshasa',
            'country' => 'DR Congo',
            'social_links' => json_encode([
                'facebook' => 'https://facebook.com/admin',
                'twitter' => 'https://twitter.com/admin',
                'instagram' => 'https://instagram.com/admin',
                'linkedin' => 'https://linkedin.com/in/admin'
            ])
        ]);
        $admin->assignRole('admin');

        // Create regular users
        for ($i = 0; $i < 20; $i++) {
            $firstName = fake()->firstName();
            $lastName = fake()->lastName();
            $username = Str::slug($firstName . $lastName . rand(1, 999));
            
            $user = User::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'username' => $username,
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
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
            $user->assignRole('user');
        }
    }
}
