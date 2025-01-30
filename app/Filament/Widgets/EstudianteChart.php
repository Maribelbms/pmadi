<?php

namespace App\Filament\Widgets;

use App\Models\Estudiante;
use App\Models\ProfesorUnidad;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class EstudianteChart extends ChartWidget
{
    
    protected static ?string $heading = '📊 Distribución de Estudiantes por Género';

    protected function getData(): array
    {
        $user = Auth::user();
        $profesor = $user->profesor;

        if (!$profesor) {
            return ['datasets' => [], 'labels' => []];
        }

        $asignaciones = ProfesorUnidad::where('profesor_id', $profesor->id)->get();
        $unidadesEducativas = $asignaciones->pluck('unidad_educativa_id')->toArray();
        $cursos = $asignaciones->pluck('curso')->toArray();
        $paralelos = $asignaciones->pluck('paralelo')->toArray();

        $estudiantes = Estudiante::whereIn('unidad_educativa_id', $unidadesEducativas)
            ->whereIn('curso', $cursos)
            ->whereIn('paralelo', $paralelos)
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Niños',
                    'data' => [$estudiantes->where('sexo', 'M')->count()],
                    'backgroundColor' => '#3498db',
                ],
                [
                    'label' => 'Niñas',
                    'data' => [$estudiantes->where('sexo', 'F')->count()],
                    'backgroundColor' => '#e74c3c',
                ],
            ],
            'labels' => ['Distribución de Género'],
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // También puedes cambiarlo a 'pie', 'line', 'doughnut'
    }
}
