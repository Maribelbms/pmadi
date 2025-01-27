<?php

namespace App\Filament\Resources\EstudianteProfesorResource\Pages;

use App\Filament\Resources\EstudianteProfesorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEstudianteProfesors extends ListRecords
{
    protected static string $resource = EstudianteProfesorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    
}
