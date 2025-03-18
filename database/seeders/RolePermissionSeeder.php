<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',
            
            // Event permissions
            'view events',
            'create events',
            'edit events',
            'delete events',
            'publish events',
            
            // Blog permissions
            'view blogs',
            'create blogs',
            'edit blogs',
            'delete blogs',
            'publish blogs',
            
            // Organizer permissions
            'view organizers',
            'create organizers',
            'edit organizers',
            'delete organizers',
            
            // Category permissions
            'manage categories',
            
            // Comment permissions
            'moderate comments'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles and assign permissions
        $roles = [
            'super-admin' => $permissions,
            'admin' => [
                'view users', 'edit users',
                'view events', 'edit events', 'publish events',
                'view blogs', 'edit blogs', 'publish blogs',
                'view organizers', 'edit organizers',
                'manage categories',
                'moderate comments'
            ],
            'organizer' => [
                'view events', 'create events', 'edit events',
                'view blogs', 'create blogs', 'edit blogs',
            ],
            'user' => [
                'view events',
                'view blogs',
                'view organizers'
            ]
        ];

        foreach ($roles as $role => $rolePermissions) {
            $createdRole = Role::create(['name' => $role]);
            $createdRole->givePermissionTo($rolePermissions);
        }
    }
}
