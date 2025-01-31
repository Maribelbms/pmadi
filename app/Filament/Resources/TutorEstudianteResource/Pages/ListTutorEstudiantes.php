<?php

namespace App\Filament\Resources\TutorEstudianteResource\Pages;

use App\Filament\Resources\TutorEstudianteResource;
use Filament\Actions;
use App\Models\Revicion;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListTutorEstudiantes extends ListRecords
{
    protected static string $resource = TutorEstudianteResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('enviarTodosAlDirector')
                ->label('Enviar Todos al Director')
                ->icon('heroicon-o-paper-airplane')
                ->color('primary')
                ->requiresConfirmation()
                ->action(function () {
                    $profesor = Auth::user()->profesor;
                    $profesorUnidad = $profesor->profesorUnidad()->first();

                    if ($profesorUnidad) {
                        // Seleccionar SOLO las revisiones de estudiantes en el curso, paralelo y unidad educativa del profesor actual
                        $reviciones = Revicion::where('estado_registro', 'inicializacion')
                            ->whereHas('estudiante', function ($query) use ($profesorUnidad) {
                            $query->where('unidad_educativa_id', $profesorUnidad->unidad_educativa_id)
                                ->where('curso', $profesorUnidad->curso)
                                ->where('paralelo', $profesorUnidad->paralelo);
                        })
                            ->get();

                        foreach ($reviciones as $revicion) {
                            $revicion->update(['estado_registro' => 'en revision']);
                        }

                        Notification::make()
                            ->title('Registros enviados')
                            ->body('Se han enviado los registros correspondientes al director.')
                            ->success()
                            ->send();
                    }
                })
                ->visible(fn() => Revicion::where('estado_registro', 'inicializacion')->exists())
        ];
    }

}
