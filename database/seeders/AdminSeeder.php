<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'nom' => 'Admin',
            'prenom' => 'System',
            'email' => 'admin@mokilievent.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'phone' => '+237 690000000',
            'bio' => 'Administrateur de la plateforme MokiliEvent',
            'avatar' => 'avatars/admin.jpg',
        ]);

        $admin->assignRole('admin');
    }
}
