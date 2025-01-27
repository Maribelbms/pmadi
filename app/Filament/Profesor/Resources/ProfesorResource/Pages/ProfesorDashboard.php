<?php

namespace App\Filament\Profesor\Pages;

use Filament\Pages\Page;
use App\Models\Estudiante;

class ProfesorDashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Panel de Profesor';

    protected static string $view = 'filament.profesor.resources.profesor-resource.pages.profesor-dashboard';

    public function getStats(): array
    {
        $totalEstudiantes = Estudiante::count();
        $estudiantesConTutor = Estudiante::whereHas('tutores')->count();
        $estudiantesSinTutor = $totalEstudiantes - $estudiantesConTutor;
        $totalNiños = Estudiante::where('sexo', 'masculino')->count();
        $totalNiñas = Estudiante::where('sexo', 'femenino')->count();

        return compact('totalEstudiantes', 'estudiantesConTutor', 'estudiantesSinTutor', 'totalNiños', 'totalNiñas');
    }
}
