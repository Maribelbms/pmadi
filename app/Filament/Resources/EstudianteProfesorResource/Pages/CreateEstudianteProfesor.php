<?php

namespace App\Filament\Resources\EstudianteProfesorResource\Pages;
use App\Models\Gestion;
use App\Models\EstudianteGestion;
use App\Filament\Resources\EstudianteProfesorResource;
use Filament\Actions;
use App\Models\ProfesorUnidad;
use Filament\Resources\Pages\CreateRecord;

class CreateEstudianteProfesor extends CreateRecord
{
    protected static string $resource = EstudianteProfesorResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Manejo del porcentaje de asistencia y habilitación
       

        return $data;
    }

    protected function afterCreate(): void
    {
        $profesorUnidad = ProfesorUnidad::where('profesor_id', auth()->user()->profesor->id ?? null)
        ->first();
        // Crear el registro en la tabla EstudianteGestion
        $this->record->gestiones()->create([
            'unidad_educativa_id' => $profesorUnidad->unidad_educativa_id,
            'gestion_id' => Gestion::where('estado', 'Activa')->first()->id_gestion,
            'nivel' => $this->data['nivel'],
            'curso' => $this->data['curso'],
            'paralelo' => $this->data['paralelo'],
            'porcentaje_asistencia' => $this->data['porcentaje_asistencia'],
            // 'habilitado' => $this->data['porcentaje_asistencia'] >= 51,
            'habilitado' => $this->data['habilitado'] === 'si', // Convierte 'si'/'no' a boolean
        ]);
    }
}
