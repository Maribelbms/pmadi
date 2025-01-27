<?php

namespace App\Filament\Resources\ProfesorResource\Pages;

use App\Filament\Resources\ProfesorResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CreateProfesor extends CreateRecord
{
    protected static string $resource = ProfesorResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
{
    // Crear o buscar el usuario en la tabla `users`
    $user = User::firstOrCreate(
        ['email' => $data['email']], // Condición para evitar duplicados
        [
            'name' => "{$data['primer_nombre']} {$data['segundo_nombre']} {$data['primer_apellido']} {$data['segundo_apellido']}",
            'password' => bcrypt($data['password']),
            'role_id' => 5, // ID del rol "Profesor"
        ]
    );

    $data['user_id'] = $user->id;

    // Buscar si ya existe un profesor con el mismo CI
    $profesor = \App\Models\Profesor::where('ci', $data['ci'])->first();

    if ($profesor) {
        // Si el profesor ya existe, actualizar su información
        $profesor->update([
            'user_id' => $user->id,
            'primer_nombre' => $data['primer_nombre'],
            'segundo_nombre' => $data['segundo_nombre'],
            'primer_apellido' => $data['primer_apellido'],
            'segundo_apellido' => $data['segundo_apellido'],
            'email' => $data['email'],
            'telefono' => $data['telefono'],
            'activo' => $data['activo'] ?? true,
        ]);

        // También actualizar la relación con unidad educativa si es necesario
        \App\Models\ProfesorUnidad::updateOrCreate(
            [
                'profesor_id' => $profesor->id,
                'unidad_educativa_id' => $data['unidad_educativa_id'],
            ],
            [
                'nivel' => $data['nivel'],
                'curso' => $data['curso'],
                'paralelo' => $data['paralelo'],
                'activo' => true,
            ]
        );

        // Devolver el `data` actualizado para el registro existente
        return $data;
    }

    // Si no existe, se creará un nuevo profesor
    $data['user_id'] = $user->id;
    return $data;
}
protected function afterCreate(): void
{
    $profesor = $this->record;

    // Crear o actualizar la relación en profesor_unidad
    \App\Models\ProfesorUnidad::updateOrCreate(
        [
            'profesor_id' => $profesor->id,
            'unidad_educativa_id' => $this->data['unidad_educativa_id'],
        ],
        [
            'nivel' => $this->data['nivel'],
            'curso' => $this->data['curso'],
            'paralelo' => $this->data['paralelo'],
            'activo' => true,
        ]
    );
}




}
