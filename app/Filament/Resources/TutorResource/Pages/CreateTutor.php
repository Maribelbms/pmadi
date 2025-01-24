<?php

namespace App\Filament\Resources\TutorResource\Pages;

use App\Filament\Resources\TutorResource;
use Filament\Actions;
use App\Models\EstudianteTutor;
use Filament\Resources\Pages\CreateRecord;

class CreateTutor extends CreateRecord
{
        protected static string $resource = TutorResource::class;
        public ?int $estudiante = null;
        protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (session()->has('estudiante')) {
            $estudiante = session()->get('estudiante');
            $data['estudiante_id'] = $estudiante->id; // Ajusta el campo según tu modelo.
        }

        return $data;
    }

    public function mount(?int $estudiante = null): void
    {
        parent::mount();

        $this->estudiante = $estudiante; // Guarda el ID del estudiante para uso posterior
    }

    public function afterSave(): void
    {
        if ($this->estudiante) {
            EstudianteTutor::create([
                'estudiante_id' => $this->estudiante,
                'tutor_id' => $this->record->id,
                'gestion_id' => now()->year, // Cambia esto si gestion_id se llena de otra manera
                'activo' => true, // Marca al tutor como activo
            ]);
        }
    }
}
