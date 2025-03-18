<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        $organizers = User::role('organizer')->get();
        $categories = Category::all();

        // Liste des images disponibles
        $images = [
            'img/events/event-1.jpg',
            'img/events/event-2.jpg',
            'img/events/event-3.jpg',
            'img/events/event-4.jpg',
            'img/events/event-5.jpg',
            'img/events/event-6.jpg',
        ];

        $events = [
            [
                'title' => 'Concert de Jazz au Parc',
                'description' => 'Une soirée exceptionnelle de jazz en plein air avec les meilleurs artistes locaux.',
                'date' => now()->addYear(),
                'location' => 'Parc de la Musique, Kinshasa',
                'is_free' => false,
                'is_featured' => true
            ],
            [
                'title' => 'Festival Gastronomique',
                'description' => 'Découvrez les saveurs uniques de la cuisine congolaise.',
                'date' => now()->addMonths(6),
                'location' => 'Place du Marché, Kinshasa',
                'is_free' => true,
                'is_featured' => true
            ],
            [
                'title' => 'Conférence Tech Innovation',
                'description' => 'Une journée dédiée aux dernières innovations technologiques.',
                'date' => now()->addMonths(3),
                'location' => 'Centre des Congrès, Kinshasa',
                'is_free' => false,
                'is_featured' => false
            ],
            [
                'title' => 'Exposition d\'Art Contemporain',
                'description' => 'Une exposition mettant en vedette les artistes émergents de la RDC.',
                'date' => now()->addMonths(2),
                'location' => 'Galerie Nationale, Kinshasa',
                'is_free' => true,
                'is_featured' => true
            ],
            [
                'title' => 'Marathon de Kinshasa',
                'description' => 'Le plus grand événement sportif de l\'année.',
                'date' => now()->addMonths(8),
                'location' => 'Centre-ville, Kinshasa',
                'is_free' => false,
                'is_featured' => false
            ],
        ];

        foreach ($events as $eventData) {
            $event = new Event();
            $event->title = $eventData['title'];
            $event->description = $eventData['description'];
            $event->start_date = $eventData['date'];
            $event->end_date = $eventData['date']->addHours(4);
            $event->location = $eventData['location'];
            $event->venue = $eventData['location'];
            $event->price = $eventData['is_free'] ? 0 : rand(5000, 50000);
            $event->total_tickets = rand(100, 1000);
            $event->available_tickets = rand(50, 100);
            $event->is_approved = true;
            $event->slug = Str::slug($eventData['title']);
            $event->image = $images[array_rand($images)];
            $event->category_id = $categories->random()->id;
            $event->user_id = $organizers->random()->id;
            $event->status = 'upcoming';
            $event->save();
        }
    }
}
