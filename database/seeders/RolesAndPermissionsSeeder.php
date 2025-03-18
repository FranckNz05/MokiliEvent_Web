<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Créer les permissions
        $permissions = [
            // Permissions pour les événements
            'create events',
            'edit events',
            'delete events',
            'publish events',
            'view events',
            
            // Permissions pour les billets
            'create tickets',
            'edit tickets',
            'delete tickets',
            'view tickets',
            
            // Permissions pour les blogs
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts',
            'view posts',
            
            // Permissions pour les commentaires
            'create comments',
            'edit comments',
            'delete comments',
            'moderate comments',
            
            // Permissions pour les utilisateurs
            'create users',
            'edit users',
            'delete users',
            'view users',
            
            // Permissions pour les organisateurs
            'manage organizers',
            'approve organizers',
            
            // Permissions pour les commandes
            'view orders',
            'manage orders',
            'cancel orders',
            
            // Permissions pour les paramètres
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Rôle Admin
        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo(Permission::all());

        // Rôle Organisateur
        $organizer = Role::create(['name' => 'organizer', 'guard_name' => 'web']);
        $organizer->givePermissionTo([
            'create events',
            'edit events',
            'delete events',
            'publish events',
            'view events',
            'create tickets',
            'edit tickets',
            'delete tickets',
            'view tickets',
            'create posts',
            'edit posts',
            'view posts',
            'create comments',
            'view orders',
        ]);

        // Rôle Utilisateur
        $user = Role::create(['name' => 'user', 'guard_name' => 'web']);
        $user->givePermissionTo([
            'view events',
            'view tickets',
            'view posts',
            'create comments',
        ]);
    }
}
