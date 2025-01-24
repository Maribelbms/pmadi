<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TutorEstudianteResource\Pages;
use App\Filament\Resources\TutorEstudianteResource\RelationManagers;
use App\Models\TutorEstudiante;
use App\Models\Tutor;
use App\Models\Estudiante;
use App\Models\Gestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TutorEstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Ingreso de Datos';
    protected static ?string $navigationGroup = 'Tutores y Estudiantes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    // Paso 1: Ingreso de los detalles del Tutor
                    Forms\Components\Wizard\Step::make('Detalles del Tutor')
                        ->schema([
                            Forms\Components\TextInput::make('ci_tutor')
                                ->label('CI del Tutor')
                                ->required()
                                ->maxLength(20)
                                ->reactive() // Habilita la actualización reactiva
                                ->afterStateUpdated(function ($state, $set, $get) {
                                    $tutor = Tutor::where('ci_tutor', $state)->first();

                                    if ($tutor) {
                                        // Autocompletar datos del tutor
                                        $set('primer_nombre_tutor', $tutor->primer_nombre_tutor);
                                        $set('segundo_nombre_tutor', $tutor->segundo_nombre_tutor);
                                        $set('primer_apellido_tutor', $tutor->primer_apellido_tutor);
                                        $set('segundo_apellido_tutor', $tutor->segundo_apellido_tutor);
                                        $set('tercer_apellido_tutor', $tutor->tercer_apellido_tutor);
                                        $set('expedido_tutor', $tutor->expedido_tutor);
                                        $set('gestion_id', $tutor->gestion_id);
                                    } else {
                                        // Habilitar campos para ingresar nuevos datos
                                        $set('primer_nombre_tutor', null);
                                        $set('segundo_nombre_tutor', null);
                                        $set('primer_apellido_tutor', null);
                                        $set('segundo_apellido_tutor', null);
                                        $set('tercer_apellido_tutor', null);
                                        $set('expedido_tutor', null);
                                        $set('gestion_id', null);
                                    }
                                }),

                            Forms\Components\TextInput::make('primer_nombre_tutor')
                                ->label('Primer Nombre del Tutor')
                                ->required()
                                ->maxLength(50)
                                ->extraAttributes(['style' => 'text-transform: uppercase;'])
                                ->disabled(fn($get) => $get('ci_tutor') && Tutor::where('ci_tutor', $get('ci_tutor'))->exists()),

                            Forms\Components\TextInput::make('segundo_nombre_tutor')
                                ->label('Segundo Nombre del Tutor')
                                ->maxLength(50)
                                ->extraAttributes(['style' => 'text-transform: uppercase;'])
                                ->disabled(fn($get) => $get('ci_tutor') && Tutor::where('ci_tutor', $get('ci_tutor'))->exists()),

                            Forms\Components\TextInput::make('primer_apellido_tutor')
                                ->label('Primer Apellido del Tutor')
                                ->required()
                                ->maxLength(100)
                                ->extraAttributes(['style' => 'text-transform: uppercase;'])
                                ->disabled(fn($get) => $get('ci_tutor') && Tutor::where('ci_tutor', $get('ci_tutor'))->exists()),

                            Forms\Components\TextInput::make('segundo_apellido_tutor')
                                ->label('Segundo Apellido del Tutor')
                                ->maxLength(100)
                                ->extraAttributes(['style' => 'text-transform: uppercase;'])
                                ->disabled(fn($get) => $get('ci_tutor') && Tutor::where('ci_tutor', $get('ci_tutor'))->exists()),

                            Forms\Components\TextInput::make('tercer_apellido_tutor')
                                ->label('Tercer Apellido del Tutor')
                                ->maxLength(100)
                                ->extraAttributes(['style' => 'text-transform: uppercase;'])
                                ->disabled(fn($get) => $get('ci_tutor') && Tutor::where('ci_tutor', $get('ci_tutor'))->exists()),

                            Forms\Components\Select::make('expedido_tutor')
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
                                ->required()
                                ->disabled(fn($get) => $get('ci_tutor') && Tutor::where('ci_tutor', $get('ci_tutor'))->exists()),

                            Forms\Components\Select::make('gestion_id')
                                ->label('Gestión')
                                ->relationship('gestion', 'nombre_gestion')
                                ->required(),
                        ])->model(Tutor::class),
 
                   
                    // Paso 2: Ingreso de los detalles del Estudiante
                    Forms\Components\Wizard\Step::make('Detalles del Estudiante')
                        ->schema([
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

                            Forms\Components\Hidden::make('tutor_id'),
                        ])
                        ->model(Estudiante::class),
                ])->columnSpanFull()


            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('primer_nombre')
                    ->label('Nombre del Estudiante')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('primer_apellido')
                    ->label('Apellido del Estudiante')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('ci')
                    ->label('CI del Estudiante')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tutor.primer_nombre_tutor')
                    ->label('Nombre del Tutor')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gestion.nombre_gestion')
                    ->label('Gestión')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('habilitado')
                    ->label('Habilitado'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTutorEstudiantes::route('/'),
            'create' => Pages\CreateTutorEstudiante::route('/create'),
            'edit' => Pages\EditTutorEstudiante::route('/{record}/edit'),
        ];
    }
}
