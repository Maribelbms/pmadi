<?php

namespace App\Observers;

use App\Models\Revicion;
use Illuminate\Support\Facades\Auth;

class RevicionObserver
{
    /**
     * Handle the Revicion "created" event.
     */
    public function created(Revicion $revicion): void
    {
        //
    }

    /**
     * Handle the Revicion "updated" event.
     */
    public function updated(Revicion $revicion): void
    {
       
        if ($revicion->isDirty('estado_registro') && $revicion->estado_registro === 'en revision') {
            $profesor = Auth::user()->profesor;

            if ($profesor) {
                $profesorUnidad = $profesor->profesorUnidad()->first();

                if ($profesorUnidad) {
                    // Obtener solo los registros que pertenecen a la unidad, curso y paralelo del profesor
                    Revicion::where('estado_registro', 'inicializacion')
                        ->whereHas('estudiante', function ($query) use ($profesorUnidad) {
                            $query->where('unidad_educativa_id', $profesorUnidad->unidad_educativa_id)
                                  ->where('curso', $profesorUnidad->curso)
                                  ->where('paralelo', $profesorUnidad->paralelo);
                        })
                        ->update(['estado_registro' => 'en revision']);
                }
            }
        }
    }

    /**
     * Handle the Revicion "deleted" event.
     */
    public function deleted(Revicion $revicion): void
    {
        //
    }

    /**
     * Handle the Revicion "restored" event.
     */
    public function restored(Revicion $revicion): void
    {
        //
    }

    /**
     * Handle the Revicion "force deleted" event.
     */
    public function forceDeleted(Revicion $revicion): void
    {
        //
    }
}
