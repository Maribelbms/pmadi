<?php

namespace App\Filament\Resources\TutorEstudianteResource\Pages;

use App\Models\Tutor;
use App\Models\Estudiante;
use App\Filament\Resources\TutorEstudianteResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class CreateTutorEstudiante extends CreateRecord
{
    protected static string $resource = TutorEstudianteResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            // Validar si ya existe un tutor con el mismo CI
            $existingTutor = Tutor::where('ci_tutor', $data['ci_tutor'])->first();
            if ($existingTutor) {
                // Si el tutor ya existe, lanzamos una excepción de validación
                throw ValidationException::withMessages([
                    'ci_tutor' => 'El CI ya está registrado para otro tutor.',
                ]);
            }

            // Crear el Tutor
            $tutor = Tutor::create([
                'primer_nombre_tutor' => $data['primer_nombre_tutor'],
                'segundo_nombre_tutor' => $data['segundo_nombre_tutor'] ?? null,
                'primer_apellido_tutor' => $data['primer_apellido_tutor'],
                'segundo_apellido_tutor' => $data['segundo_apellido_tutor'] ?? null,
                'tercer_apellido_tutor' => $data['tercer_apellido_tutor'] ?? null,
                'ci_tutor' => $data['ci_tutor'],
                'expedido_tutor' => $data['expedido_tutor'],
                'gestion_id' => $data['gestion_id'],
            ]);

            // Crear el Estudiante usando el ID del Tutor
            $estudiante = Estudiante::create([
                'primer_nombre' => $data['primer_nombre'],
                'segundo_nombre' => $data['segundo_nombre'] ?? null,
                'primer_apellido' => $data['primer_apellido'],
                'segundo_apellido' => $data['segundo_apellido'] ?? null,
                'ci' => $data['ci'],
                'expedido' => $data['expedido'],
                'sexo' => $data['sexo'],
                'rude' => $data['rude'],
                'nivel' => $data['nivel'],
                'curso' => $data['curso'],
                'paralelo' => $data['paralelo'],
                'porcentaje_asistencia' => $data['porcentaje_asistencia'],
                'tutor_id' => $tutor->id,
            ]);

            return $estudiante;
        });
    }
}
