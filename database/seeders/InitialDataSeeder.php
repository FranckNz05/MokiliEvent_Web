<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Créer les catégories
        $categories = [
            [
                'name' => 'Concerts',
                'slug' => 'concerts',
                'icon' => 'music',
                'description' => 'Concerts et spectacles musicaux'
            ],
            [
                'name' => 'Conférences',
                'slug' => 'conferences',
                'icon' => 'microphone',
                'description' => 'Conférences et séminaires'
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'icon' => 'futbol',
                'description' => 'Événements sportifs'
            ],
            [
                'name' => 'Festivals',
                'slug' => 'festivals',
                'icon' => 'guitar',
                'description' => 'Festivals et célébrations'
            ],
            [
                'name' => 'Théâtre',
                'slug' => 'theatre',
                'icon' => 'theater-masks',
                'description' => 'Pièces de théâtre et spectacles'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Créer un utilisateur admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@mokilievent.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'status' => 'active'
        ]);
        $admin->assignRole('admin');

        // Créer un organisateur
        $organizer = User::create([
            'name' => 'Organisateur Test',
            'email' => 'organizer@mokilievent.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'status' => 'active'
        ]);
        $organizer->assignRole('organizer');

        // Créer des événements
        $events = [
            [
                'title' => 'Concert de Fally Ipupa',
                'category_id' => 1,
                'description' => 'Le plus grand concert de l\'année avec Fally Ipupa',
                'start_date' => Carbon::now()->addDays(30),
                'end_date' => Carbon::now()->addDays(30)->addHours(4),
                'location' => 'Stade des Martyrs, Kinshasa',
                'price' => 50000,
                'total_tickets' => 1000,
                'available_tickets' => 1000,
                'is_featured' => true,
                'status' => 'approved'
            ],
            [
                'title' => 'Conférence sur l\'IA',
                'category_id' => 2,
                'description' => 'Découvrez les dernières avancées en Intelligence Artificielle',
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(15)->addHours(3),
                'location' => 'Pullman Hotel, Kinshasa',
                'price' => 25000,
                'total_tickets' => 200,
                'available_tickets' => 200,
                'is_featured' => true,
                'status' => 'approved'
            ],
            [
                'title' => 'Match de Football',
                'category_id' => 3,
                'description' => 'Match amical international',
                'start_date' => Carbon::now()->addDays(45),
                'end_date' => Carbon::now()->addDays(45)->addHours(2),
                'location' => 'Stade des Martyrs, Kinshasa',
                'price' => 15000,
                'total_tickets' => 500,
                'available_tickets' => 500,
                'is_featured' => false,
                'status' => 'approved'
            ]
        ];

        foreach ($events as $eventData) {
            $eventData['user_id'] = $organizer->id;
            $eventData['slug'] = Str::slug($eventData['title']);
            Event::create($eventData);
        }
    }
}
