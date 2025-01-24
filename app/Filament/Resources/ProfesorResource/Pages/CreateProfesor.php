<?php

namespace App\Filament\Resources\ProfesorResource\Pages;

use App\Filament\Resources\ProfesorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;

class CreateProfesor extends CreateRecord
{
    protected static string $resource = ProfesorResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Crear o asociar el usuario
        $user = User::firstOrCreate(
            ['email' => $data['email']], // Buscar por email
            [
                'name' => $data['primer_nombre'] . ' ' . $data['primer_apellido'],
                'password' => bcrypt('password123'), // Cambia esto por una lógica adecuada para generar contraseñas
                'active' => true,
            ]
        );

        // Asignar el rol de profesor al usuario
        $user->assignRole('profesor');

        // Asociar el `user_id` al profesor
        $data['user_id'] = $user->id;

        return $data;
    }
}
