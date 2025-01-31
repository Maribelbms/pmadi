<?php

namespace App\Filament\Widgets;

use App\Models\Estudiante;
use App\Models\ProfesorUnidad;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Auth;

class PanelesUsuarios extends BaseWidget
{
    protected static ?string $heading = '📌 Panel de Estadísticas';
    protected static bool $isLazy = false;
    protected static bool $isStatic = true;
    protected static ?int $sort = 1; // Prioridad alta para que aparezca arriba
    

    protected function getStats(): array
    {
        $user = Auth::user();
        $profesor = Auth::user()->profesor;

        if (!$profesor) {
            return [];
        }

        $asignaciones = ProfesorUnidad::where('profesor_id', $profesor->id)->get();

        if ($asignaciones->isEmpty()) {
            return [
                Card::make('⚠️ No hay estudiantes registrados', 'Verifica tu unidad educativa, curso y paralelo.')
                    ->color('yellow')
            ];
        }

        $unidadesEducativas = $asignaciones->pluck('unidad_educativa_id')->toArray();
        $cursos = $asignaciones->pluck('curso')->toArray();
        $paralelos = $asignaciones->pluck('paralelo')->toArray();

        $estudiantes = Estudiante::whereIn('unidad_educativa_id', $unidadesEducativas)
            ->whereIn('curso', $cursos)
            ->whereIn('paralelo', $paralelos)
            ->get();

        $totalEstudiantes = $estudiantes->count();
        $niños = $estudiantes->where('sexo', 'M')->count();
        $niñas = $estudiantes->where('sexo', 'F')->count();

        if ($totalEstudiantes === 0) {
            return [
                Card::make('⚠️ No hay estudiantes registrados', 'Verifica tu unidad educativa, curso y paralelo.')
                    ->color('yellow')
            ];
        }

        return [
            Card::make('👨‍🏫 Bienvenido ' . strtoupper($user->name), '')
                ->description('Estadísticas de su curso y paralelo')
                ->descriptionIcon('heroicon-o-user'),

            Card::make('📌 Total de Estudiantes', $totalEstudiantes)
                ->description('Estudiantes activos')
                ->color('primary')
                ->icon('heroicon-o-user-group'),

            Card::make('👦 Niños', $niños)
                ->color('blue')
                ->icon('heroicon-o-user'),

            Card::make('👧 Niñas', $niñas)
                ->color('pink')
                ->icon('heroicon-o-user'),
        ];
    }

    protected function getColumns(): int
    {
        return 2; // Cards en 2 columnas
    }

    // 📌 Aquí agregamos los gráficos al final
    public function getFooterWidgets(): array
    {
        return [
            EstudianteChart::class, // 📊 La gráfica de distribución de estudiantes
        ];
    }
    
}
