<?php

namespace App\Filament\Resources\ProfesorResource\Pages;

use App\Filament\Resources\ProfesorResource;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;
use App\Models\Director;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use App\Models\Profesor;
use App\Models\ProfesorUnidad;

class CreateProfesor extends CreateRecord
{
    protected static string $resource = ProfesorResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $director = Director::where('user_id', Auth::id())->first();

        if (!$director || !$director->unidad_educativa_id) {
            throw ValidationException::withMessages([
                'unidad_educativa_id' => 'Solo el Director puede asignar un profesor y debe tener una Unidad Educativa asignada.',
            ]);

        }

        $unidadEducativaId = $director->unidad_educativa_id;

        // Verificar si ya existe un profesor en el mismo curso, paralelo y unidad educativa
        $existeProfesor = ProfesorUnidad::where([
            ['unidad_educativa_id', '=', $unidadEducativaId],
            ['curso', '=', $data['curso']],
            ['paralelo', '=', $data['paralelo']],
        ])->exists();

        if ($existeProfesor) {
            throw ValidationException::withMessages([
                'data.paralelo' => 'Ya existe un profesor asignado a este curso y paralelo.',
            ]);

        }

        // Buscar o crear usuario
        $user = User::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => "{$data['primer_nombre']} {$data['segundo_nombre']} {$data['primer_apellido']} {$data['segundo_apellido']}",
                'password' => bcrypt($data['password']),
            ]
        );

        $user->assignRole('profesor');
        $data['user_id'] = $user->id;

        // Verificar si ya existe un profesor con el mismo CI
        $profesor = Profesor::where('ci', $data['ci'])->first();

        if ($profesor) {
            // Actualizar los datos del profesor si ya existe
            $profesor->update([
                'user_id' => $user->id,
                'primer_nombre' => $data['primer_nombre'],
                'segundo_nombre' => $data['segundo_nombre'],
                'primer_apellido' => $data['primer_apellido'],
                'segundo_apellido' => $data['segundo_apellido'],
                'email' => $data['email'],
                'telefono' => $data['telefono'],
                'activo' => $data['activo'] ?? true,
                'unidad_educativa_id'=>$unidadEducativaId,
            ]);

            // Actualizar o crear la relación con unidad educativa
            ProfesorUnidad::updateOrCreate(
                [
                    'profesor_id' => $profesor->id,
                    'unidad_educativa_id' => $unidadEducativaId,
                ],
                [
                    'nivel' => $data['nivel'] ?? 'INICIAL',
                    'curso' => $data['curso'],
                    'paralelo' => $data['paralelo'],
                    'activo' => true,
                ]
            );

            return $data;
        }

        // Si el profesor no existe, proceder con la creación
        return $data;
    }

    protected function afterCreate(): void
    {
        $director = Director::where('user_id', Auth::id())->first();

        if (!$director || !$director->unidad_educativa_id) {
            throw ValidationException::withMessages([
                'unidad_educativa_id' => 'Solo el Director puede asignar un profesor y debe tener una Unidad Educativa asignada.',
            ]);

        }

        $unidadEducativaId = $director->unidad_educativa_id;
        $profesor = $this->record;

        ProfesorUnidad::updateOrCreate(
            [
                'profesor_id' => $profesor->id,
                'unidad_educativa_id' => $unidadEducativaId,
            ],
            [
                'nivel' => $this->data['nivel'] ?? 'INICIAL',
                'curso' => $this->data['curso'],
                'paralelo' => $this->data['paralelo'],
                'activo' => true,
            ]
        );
    }
}
