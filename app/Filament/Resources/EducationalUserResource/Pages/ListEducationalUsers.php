<?php

namespace App\Filament\Resources\EducationalUserResource\Pages;

use App\Filament\Resources\EducationalUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEducationalUsers extends ListRecords
{
    protected static string $resource = EducationalUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
