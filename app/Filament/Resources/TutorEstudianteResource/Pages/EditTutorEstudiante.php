<?php

namespace App\Filament\Resources\TutorEstudianteResource\Pages;

use App\Filament\Resources\TutorEstudianteResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\Tutor;
use Filament\Forms;

class EditTutorEstudiante extends EditRecord
{
    protected static string $resource = TutorEstudianteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Actualizar o crear el Tutor antes de guardar el Estudiante
        $tutor = Tutor::updateOrCreate(
            ['ci_tutor' => $data['ci_tutor']],
            [
                'primer_nombre_tutor' => $data['primer_nombre_tutor'],
                'segundo_nombre_tutor' => $data['segundo_nombre_tutor'],
                'primer_apellido_tutor' => $data['primer_apellido_tutor'],
                'segundo_apellido_tutor' => $data['segundo_apellido_tutor'],
                'tercer_apellido_tutor' => $data['tercer_apellido_tutor'],
                'expedido_tutor' => $data['expedido_tutor'],
                'gestion_id' => $data['gestion_id'],
            ]
        );

        // Asociar el tutor creado/actualizado al estudiante
        $data['tutor_id'] = $tutor->id;

        return $data;
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Prellenar datos del Tutor si ya existe
        $tutor = Tutor::find($this->record->tutor_id);

        if ($tutor) {
            $data['ci_tutor'] = $tutor->ci_tutor;
            $data['primer_nombre_tutor'] = $tutor->primer_nombre_tutor;
            $data['segundo_nombre_tutor'] = $tutor->segundo_nombre_tutor;
            $data['primer_apellido_tutor'] = $tutor->primer_apellido_tutor;
            $data['segundo_apellido_tutor'] = $tutor->segundo_apellido_tutor;
            $data['tercer_apellido_tutor'] = $tutor->tercer_apellido_tutor;
            $data['expedido_tutor'] = $tutor->expedido_tutor;
            $data['gestion_id'] = $tutor->gestion_id;
        }

        return $data;
    }

    protected function afterSave(): void
    {
        session()->flash('success', '¡El registro ha sido actualizado correctamente!');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\TextInput::make('ci')
                ->label('CI del Estudiante')
                ->required()
                ->unique('estudiantes', 'ci', ignoreRecord: true), // Ignorar el registro actual en la validación
            Forms\Components\TextInput::make('rude')
                ->label('RUDE')
                ->required()
                ->unique('estudiantes', 'rude', ignoreRecord: true), // Ignorar el registro actual en la validación
            Forms\Components\TextInput::make('primer_nombre')
                ->label('Primer Nombre del Estudiante')
                ->required(),
            Forms\Components\TextInput::make('primer_apellido')
                ->label('Primer Apellido del Estudiante')
                ->required(),
            Forms\Components\Select::make('expedido')
                ->label('Expedido')
                ->options([
                    'LP' => 'La Paz',
                    'CB' => 'Cochabamba',
                    'SC' => 'Santa Cruz',
                    'OR' => 'Oruro',
                    'PT' => 'Potosí',
                    'TJ' => 'Tarija',
                    'CH' => 'Chuquisaca',
                    'PD' => 'Pando',
                    'BN' => 'Beni',
                ])
                ->required(),
            Forms\Components\TextInput::make('ci_tutor')
                ->label('CI del Tutor')
                ->required(),
            Forms\Components\TextInput::make('primer_nombre_tutor')
                ->label('Primer Nombre del Tutor')
                ->required(),
            // Agregar más campos según sea necesario...
        ];
    }
}
