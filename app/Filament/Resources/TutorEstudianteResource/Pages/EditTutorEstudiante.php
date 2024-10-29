<?php

namespace App\Filament\Resources\TutorEstudianteResource\Pages;

use App\Filament\Resources\TutorEstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTutorEstudiante extends EditRecord
{
    protected static string $resource = TutorEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
