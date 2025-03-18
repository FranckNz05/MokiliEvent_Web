<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Création des rôles
        $admin = Role::create(['name' => 'admin']);
        $organizer = Role::create(['name' => 'organizer']);
        $user = Role::create(['name' => 'user']);

        // Création des permissions
        $permissions = [
            // Permissions pour les événements
            'create events',
            'edit events',
            'delete events',
            'approve events',
            'view events',
            
            // Permissions pour les utilisateurs
            'manage users',
            'view users',
            
            // Permissions pour les catégories
            'manage categories',
            
            // Permissions pour les blogs
            'manage blogs',
            'create blogs',
            'edit blogs',
            'delete blogs',
            'view blogs',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Attribution des permissions aux rôles
        $admin->givePermissionTo(Permission::all());
        
        $organizer->givePermissionTo([
            'create events',
            'edit events',
            'delete events',
            'view events',
            'create blogs',
            'edit blogs',
            'delete blogs',
            'view blogs',
        ]);
        
        $user->givePermissionTo([
            'view events',
            'view blogs',
        ]);
    }
}
