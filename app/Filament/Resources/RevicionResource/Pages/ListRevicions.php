<?php

namespace App\Filament\Resources\RevicionResource\Pages;

use App\Filament\Resources\RevicionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRevicions extends ListRecords
{
    protected static string $resource = RevicionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
