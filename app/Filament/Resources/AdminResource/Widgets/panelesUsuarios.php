<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Estudiante;

class panelesUsuarios extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Estudiantes', Estudiante::count()),
        ];
    }
}
