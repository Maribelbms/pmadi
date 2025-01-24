<?php

namespace App\Filament\ProfesorPanel\Resources\NotificacionResource\Pages;

use App\Filament\ProfesorPanel\Resources\NotificacionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNotificacion extends EditRecord
{
    protected static string $resource = NotificacionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
