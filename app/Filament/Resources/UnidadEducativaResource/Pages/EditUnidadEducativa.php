<?php

namespace App\Filament\Resources\UnidadEducativaResource\Pages;

use App\Filament\Resources\UnidadEducativaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUnidadEducativa extends EditRecord
{
    protected static string $resource = UnidadEducativaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
