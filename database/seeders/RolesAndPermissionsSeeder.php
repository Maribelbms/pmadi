<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crear Permisos
        $permissions = [
            'manage users',
            'manage roles',
            'manage permissions',
            'view dashboard',

            // Permisos específicos para Profesor
            'view students',
            'create students',
            'update students',
            'delete students',
            'view notifications',
            'mark notifications as read',
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear Roles
        $adminRole = Role::create(['name' => 'admin']);
        $profesorRole = Role::create(['name' => 'profesor']);
        $userRole = Role::create(['name' => 'user']);


        // Asignar Permisos a Roles
        $adminRole->givePermissionTo(Permission::all());

        $profesorPermissions = [
            'view students',
            'create students',
            'delete students',
            'edit students',
            'update students',
            'view notifications',
            'mark notifications as read',
        ];
        $profesorRole->syncPermissions($profesorPermissions);

        // Usuario básico (sin permisos asignados por ahora)
        $userRole->syncPermissions([]);



    }
}
