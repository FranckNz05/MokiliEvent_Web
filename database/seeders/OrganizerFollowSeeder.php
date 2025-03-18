<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organizer;
use App\Models\OrganizerFollow;
use Illuminate\Database\Seeder;

class OrganizerFollowSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::role('user')->get();
        $organizers = Organizer::all();

        // Create random follows
        foreach ($users as $user) {
            // Each user follows 1-5 random organizers
            $followCount = rand(1, 5);
            $randomOrganizers = $organizers->random($followCount);

            foreach ($randomOrganizers as $organizer) {
                OrganizerFollow::create([
                    'user_id' => $user->id,
                    'organizer_id' => $organizer->id,
                    'created_at' => fake()->dateTimeBetween('-1 year', 'now')
                ]);
            }
        }
    }
}
