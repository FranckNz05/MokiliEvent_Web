<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Créer l'administrateur
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@mokilievent.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Créer les organisateurs
        $organisateurs = [
            [
                'name' => 'Jean Dupont',
                'email' => 'jean@mokilievent.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Marie Martin',
                'email' => 'marie@mokilievent.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Pierre Dubois',
                'email' => 'pierre@mokilievent.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($organisateurs as $org) {
            $user = User::create($org);
            $user->assignRole('organizer');
        }

        // Créer les clients
        $clients = [
            [
                'name' => 'Sophie Laurent',
                'email' => 'sophie@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Lucas Bernard',
                'email' => 'lucas@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Emma Petit',
                'email' => 'emma@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Thomas Moreau',
                'email' => 'thomas@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Julie Roux',
                'email' => 'julie@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($clients as $client) {
            $user = User::create($client);
            $user->assignRole('client');
        }
    }
}
