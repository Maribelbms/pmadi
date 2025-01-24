<?php

namespace App\Filament\Resources\TutorEstudianteResource\Pages;

use App\Filament\Resources\TutorEstudianteResource;
use App\Models\Tutor;
use App\Models\Estudiante;
use Filament\Resources\Pages\CreateRecord;

class CreateTutorEstudiante extends CreateRecord
{
    protected static string $resource = TutorEstudianteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Verificar si el tutor ya existe o crear uno nuevo
        $tutor = Tutor::firstOrCreate(
            ['ci_tutor' => $data['ci_tutor']],
            [
                'primer_nombre_tutor' => $data['primer_nombre_tutor'] ?? null,
                'segundo_nombre_tutor' => $data['segundo_nombre_tutor'] ?? null,
                'primer_apellido_tutor' => $data['primer_apellido_tutor'] ?? null,
                'segundo_apellido_tutor' => $data['segundo_apellido_tutor'] ?? null,
                'tercer_apellido_tutor' => $data['tercer_apellido_tutor'] ?? null,
                'expedido_tutor' => $data['expedido_tutor'] ?? null, 
                'gestion_id' => $data['gestion_id'] ?? null,
            ]
        );

        // Asignar el ID del tutor al estudiante
        $data['tutor_id'] = $tutor->id_tutor;
        

        // Retornar los datos modificados
        return $data;
    }
}
