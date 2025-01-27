<?php

namespace App\Filament\Resources\EstudianteProfesorResource\Pages;

use App\Filament\Resources\EstudianteProfesorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEstudianteProfesor extends EditRecord
{
    protected static string $resource = EstudianteProfesorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
