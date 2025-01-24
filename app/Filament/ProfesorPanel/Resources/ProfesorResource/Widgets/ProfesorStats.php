<?php

namespace App\Filament\ProfesorPanel\Resources\ProfesorResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\Estudiante;
use App\Models\Notificacion;

class ProfesorStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Card::make('Estudiantes Registrados', Estudiante::count()),
            // Card::make('Notificaciones Pendientes', Notificacion::where('leido', false)->count()),
        ];
    }
}
