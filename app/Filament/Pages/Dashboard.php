<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\PanelesUsuarios;
use App\Filament\Widgets\EstudianteChart;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        return [
            PanelesUsuarios::class, // 📌 Cards primero
        EstudianteChart::class, // 📊 Gráficos después

        ];
    }
}
