<?php

namespace App\Observers;

use App\Models\Estudiante;
use App\Models\Revicion;
class EstudianteObserver
{
    /**
     * Handle the Estudiante "created" event.
     */
    public function created(Estudiante $estudiante): void
    {
        if ($estudiante->tutor_id) {
            // Verificar si ya existe una revisión para este estudiante
            $existeRevicion = Revicion::where('estudiante_id', $estudiante->id_estudiante)->exists();
    
            if (!$existeRevicion) {
                Revicion::create([
                    'estudiante_id' => $estudiante->id_estudiante,
                    'tutor_id' => $estudiante->tutor_id,
                    'estado_registro' => 'inicializacion',
                ]);
            }
        }
    }

    /**
     * Handle the Estudiante "updated" event.
     */
    public function updated(Estudiante $estudiante): void
    {
        //
    }

    /**
     * Handle the Estudiante "deleted" event.
     */
    public function deleted(Estudiante $estudiante): void
    {
        //
    }

    /**
     * Handle the Estudiante "restored" event.
     */
    public function restored(Estudiante $estudiante): void
    {
        //
    }

    /**
     * Handle the Estudiante "force deleted" event.
     */
    public function forceDeleted(Estudiante $estudiante): void
    {
        //
    }
}
