<?php

namespace App\Filament\Resources\TutorEstudianteResource\Pages;

use App\Filament\Resources\TutorEstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTutorEstudiantes extends ListRecords
{
    protected static string $resource = TutorEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
