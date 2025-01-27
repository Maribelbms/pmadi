<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstudianteResource\Pages;
use App\Filament\Resources\EstudianteResource\RelationManagers;
use App\Models\Estudiante;
use App\Models\Tutor;
use App\Models\EstudianteTutor;
use Filament\Forms;
use Filament\Forms\Form;
use Livewire\Livewire;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Step;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;

    // protected static ?string $navigationGroup = 'Registro';
    // protected static ?string $navigationIcon = 'heroicon-o-user-group';
    // protected static ?string $pluralLabel = 'Estudiantes';
    // protected static ?string $label = 'Estudiante';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // INGRESO DE DATOS DEL ESTUDIANTE
                Forms\Components\TextInput::make('primer_nombre')
                    ->label('Primer Nombre del Estudiante')
                    ->required()
                    ->maxLength(50)
                    ->extraAttributes(['style' => 'text-transform: uppercase;'])
                    ->afterStateUpdated(function ($state, $set) {
                        $set('primer_nombre', strtoupper($state));
                    }),
                Forms\Components\TextInput::make('segundo_nombre')
                    ->label('Segundo Nombre del Estudiante')
                    ->maxLength(50)
                    ->extraAttributes(['style' => 'text-transform: uppercase;'])
                    ->afterStateUpdated(function ($state, $set) {
                        $set('segundo_nombre', strtoupper($state));
                    }),
                Forms\Components\TextInput::make('primer_apellido')
                    ->label('Primer Apellido del Estudiante')
                    ->required()
                    ->maxLength(100)
                    ->extraAttributes(['style' => 'text-transform: uppercase;'])
                    ->afterStateUpdated(function ($state, $set) {
                        $set('primer_apellido', strtoupper($state));
                    }),

                Forms\Components\TextInput::make('segundo_apellido')
                    ->label('Segundo Apellido del Estudiante')
                    ->maxLength(100)
                    ->extraAttributes(['style' => 'text-transform: uppercase;'])
                    ->afterStateUpdated(function ($state, $set) {
                        $set('segundo_apellido', strtoupper($state));
                    }),
                Forms\Components\TextInput::make('ci')
                    ->label('CI del Estudiante')
                    ->required()
                    ->maxLength(30)
                    ->unique(Estudiante::class, 'ci'),

                Forms\Components\Select::make('expedido')
                    ->label('Expedido')
                    ->options([
                        'QR' => 'QR',
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

                Forms\Components\Select::make('sexo')
                    ->label('Sexo')
                    ->options([
                        'M' => 'Masculino',
                        'F' => 'Femenino',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('rude')
                    ->label('RUDE')
                    ->unique(Estudiante::class, 'rude')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nivel')
                    ->label('Nivel')
                    ->default('INICIAL')
                    ->required()
                    ->disabled(),
                Forms\Components\Select::make('curso')
                    ->label('Curso')
                    ->options([
                        '1' => 'PRIMERA SECCION',
                        '2' => 'SEGUNDA SECCION',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('paralelo')
                    ->label('Paralelo')
                    ->required()
                    ->maxLength(2),
                Forms\Components\TextInput::make('porcentaje_asistencia')
                    ->label('Porcentaje de Asistencia')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.01)
                    ->required()
                    ->reactive() // Hacer reactivo el campo para que detecte cambios
                    ->afterStateUpdated(function ($state, $set) {
                        $set('habilitado', $state >= 51 ? 'si' : 'no');
                    }),
                Forms\Components\Hidden::make('habilitado'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('primer_nombre')
                    ->label('Primer Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('segundo_nombre')
                    ->label('Segundo Nombre')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('primer_apellido')
                    ->label('Primer Apellido')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('segundo_apellido')
                    ->label('Segundo Apellido')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ci')
                    ->label('CI')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('expedido')
                    ->label('Expedido')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('sexo')
                    ->label('Genero')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('rude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nivel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('curso')
                    ->searchable(),
                Tables\Columns\TextColumn::make('paralelo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('porcentaje_asistencia')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('habilitado')
                    ->label('Habilitado')
                    ->colors([
                        'success' => 'si',
                        'danger' => 'no',
                    ]),
                Tables\Columns\TextColumn::make('tutorActivo')
                    ->label('Estado del Tutor')
                    ->formatStateUsing(fn($record) => $record->tutorActivo ? '🟢 Asignado' : '🔴 No Asignado')
                    ->color(fn($record) => $record->tutorActivo ? 'green' : 'red')
                    ->default('🔴 No Asignado'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\Action::make('asignar-tutor')
                // ->url(fn ($record) => route('filament.resources.tutors.create', ['estudiante' => $record->id_estudiante]))
                // ->label('Asignar Tutor')
                //     ->icon('heroicon-o-user')
                //     ->color('danger'),
                Tables\Actions\Action::make('asignarTutor')
                    ->label('Asignar Tutor')
                    ->icon('heroicon-o-user')              
                    ->modalHeading('Asignar Tutor')
                    ->modalWidth('4xl')
                    // ->action(function ($record) {
                    //     Livewire::emit('openModal', 'assign-tutor-modal', ['estudiante' => $record->id]);
                    // }),
                    ->form([
                        Forms\Components\Wizard::make([
                            // Paso 1: Detalles del Tutor
                            Forms\Components\Wizard\Step::make('Detalles del Tutor')
                                ->schema([
                                    TextInput::make('ci_tutor')
                                        ->label('CI del Tutor')
                                        ->required()
                                        ->maxLength(20)
                                        ->reactive()
                                        ->afterStateUpdated(function ($state, $set) {
                                            $tutor = Tutor::where('ci', $state)->first();
                                            if ($tutor) {
                                                $set('primer_nombre_tutor', $tutor->primer_nombre);
                                                $set('segundo_nombre_tutor', $tutor->segundo_nombre);
                                                $set('primer_apellido_tutor', $tutor->primer_apellido);
                                                $set('segundo_apellido_tutor', $tutor->segundo_apellido);
                                                $set('tercer_apellido_tutor', $tutor->tercer_apellido);
                                                $set('expedido_tutor', $tutor->expedido);
                                            } else {
                                                $set('primer_nombre_tutor', null);
                                                $set('segundo_nombre_tutor', null);
                                                $set('primer_apellido_tutor', null);
                                                $set('segundo_apellido_tutor', null);
                                                $set('tercer_apellido_tutor', null);
                                                $set('expedido_tutor', null);
                                            }
                                        }),
                                    TextInput::make('primer_nombre_tutor')
                                        ->label('Primer Nombre del Tutor')
                                        ->required()
                                        ->maxLength(50),
                                    TextInput::make('segundo_nombre_tutor')
                                        ->label('Segundo Nombre del Tutor')
                                        ->maxLength(50),
                                    TextInput::make('primer_apellido_tutor')
                                        ->label('Primer Apellido del Tutor')
                                        ->required()
                                        ->maxLength(100),
                                    TextInput::make('segundo_apellido_tutor')
                                        ->label('Segundo Apellido del Tutor')
                                        ->maxLength(100),
                                    TextInput::make('tercer_apellido_tutor')
                                        ->label('Tercer Apellido del Tutor')
                                        ->maxLength(100),
                                    Select::make('expedido_tutor')
                                        ->label('Expedición del CI del Tutor')
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
                                ]),
                        ]),


                    ])

                    ->action(function (array $data, $record) {
                        $tutor = Tutor::create([
                            'primer_nombre_tutor' => $data['primer_nombre_tutor'],
                            'segundo_nombre_tutor' => $data['segundo_nombre_tutor'],
                            'primer_apellido_tutor' => $data['primer_apellido_tutor'],
                            'segundo_apellido_tutor' => $data['segundo_apellido_tutor'],
                            'tercer_apellido_tutor' => $data['tercer_apellido_tutor'],
                            'ci_tutor' => $data['ci_tutor'],
                            'expedido_tutor' => $data['expedido_tutor'],
                        ]);

                        EstudianteTutor::create([
                            'estudiante_id' => $record->id_estudiante,
                            'tutor_id' => $tutor->id_tutor,
                            'activo' => true,
                            'gestion_id' => 1, // Obtener esta gestión dinámicamente si es necesario
                        ]);
                    }),


            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers\EstudianteTutorRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEstudiantes::route('/'),
            'create' => Pages\CreateEstudiante::route('/create'),
            'edit' => Pages\EditEstudiante::route('/{record}/edit'),
        ];
    }
}
