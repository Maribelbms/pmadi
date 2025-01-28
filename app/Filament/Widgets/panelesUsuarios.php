<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Estudiante;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Card;

class panelesUsuarios extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            // Tarjeta para el total de usuarios
            Card::make('Usuarios Totales', User::count())
                ->description('Todos los usuarios del sistema')
                ->descriptionIcon('heroicon-o-user-group'),

            // Tarjeta para el total de estudiantes
            Card::make('Estudiantes Registrados', Estudiante::count())
                ->description('Estudiantes activos en el sistema')
                ->descriptionIcon('heroicon-o-academic-cap'),

            // Tarjeta para el total de profesores
            //  Card::make('Profesores Registrados', User::role('profesor')->count())
            //      ->description('Profesores registrados')
            //      ->descriptionIcon('heroicon-o-user'),
        ];
    }
}
