<?php

namespace App\Filament\Resources\EducationalUserResource\Pages;

use App\Filament\Resources\EducationalUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEducationalUser extends EditRecord
{
    protected static string $resource = EducationalUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
