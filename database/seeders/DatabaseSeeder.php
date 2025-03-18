<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            TagSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            OrganizerSeeder::class,
            EventSeeder::class,
            BlogSeeder::class,
            CommentSeeder::class,
            LikeSeeder::class,
            ViewSeeder::class,
        ]);
    }
}
