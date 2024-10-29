<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstudianteResource\Pages;
use App\Filament\Resources\EstudianteResource\RelationManagers;
use App\Models\Estudiante;
use App\Models\Tutor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;
    protected static ?string $modelo = Tutor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Detalles del Estudiante')
                        ->schema([
                            Forms\Components\TextInput::make('primer_nombre')
                                ->label('Primer Nombre')
                                ->required()
                                ->maxLength(50),

                            Forms\Components\TextInput::make('segundo_nombre')
                                ->label('Segundo Nombre')
                                ->maxLength(50),

                            Forms\Components\TextInput::make('primer_apellido')
                                ->label('Primer Apellido')
                                ->required()
                                ->maxLength(100),

                            Forms\Components\TextInput::make('segundo_apellido')
                                ->label('Segundo Apellido')
                                ->maxLength(100),

                            Forms\Components\TextInput::make('ci')
                                ->label('Carnet de Identidad')
                                ->required()
                                ->maxLength(30)
                                ->unique(table: 'estudiantes', column: 'ci'),

                            Forms\Components\TextInput::make('expedido')
                                ->label('Expedido')
                                ->required()
                                ->options([
                                    'LP' => 'La Paz',
                                    'CB' => 'Cochabamba',
                                    'SC' => 'Santa Cruz',

                                ])
                                ->maxLength(2),

                            Forms\Components\Select::make('sexo')
                                ->label('Sexo')
                                ->required()
                                ->options([
                                    'M' => 'Masculino',
                                    'F' => 'Femenino',
                                ]),

                            Forms\Components\TextInput::make('rude')
                                ->label('RUDE')
                                ->required()
                                ->unique(table: 'estudiantes', column: 'rude')
                                ->maxLength(100),

                            Forms\Components\TextInput::make('nivel')
                                ->label('Nivel')
                                ->default('INICIAL')
                                ->required()
                                ->maxLength(50),

                            Forms\Components\TextInput::make('curso')
                                ->label('Curso')
                                ->required()
                                ->options([
                                    '1' => '1',
                                    '2' => '2',
                                ]),
                                // ->maxLength(50),

                            Forms\Components\TextInput::make('paralelo')
                                ->label('Paralelo')
                                ->required()
                                ->maxLength(2),

                            Forms\Components\TextInput::make('porcentaje_asistencia')
                                ->label('Porcentaje de Asistencia')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->maxValue(100)
                                ->step(0.01),

                            Forms\Components\Toggle::make('habilitado')
                                ->label('Habilitado')
                                ->default(true),
                        ]),

                    Forms\Components\Wizard\Step::make('Detalles del Tutor')
                        ->schema([
                            Forms\Components\TextInput::make('primer_nombre_tutor')
                                ->label('Primer Nombre del Tutor')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\TextInput::make('segundo_nombre_tutor')
                                ->label('Segundo Nombre del Tutor')
                                ->maxLength(255),

                            Forms\Components\TextInput::make('primer_apellido_tutor')
                                ->label('Primer Apellido del Tutor')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\TextInput::make('segundo_apellido_tutor')
                                ->label('Segundo Apellido del Tutor')
                                ->required()
                                ->maxLength(255),

                            Forms\Components\TextInput::make('tercer_apellido_tutor')
                                ->label('Tercer Apellido del Tutor')
                                ->maxLength(255),

                            Forms\Components\TextInput::make('ci_tutor')
                                ->label('CI del Tutor')
                                ->required()
                                ->maxLength(20)
                                ->unique(table: 'estudiantes', column: 'ci_tutor'),

                            Forms\Components\TextInput::make('expedido_tutor')
                                ->label('Expedición del CI del Tutor')
                                ->required()
                                ->maxLength(10),
                        ]),
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_estudiante')
                    ->label('ID')
                    ->sortable(),

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
                    ->label('Carnet de Identidad')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('expedido')
                    ->label('Expedido')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('sexo')
                    ->label('Sexo')
                    ->sortable(),

                Tables\Columns\TextColumn::make('rude')
                    ->label('RUDE')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('nivel')
                    ->label('Nivel')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('curso')
                    ->label('Curso')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('paralelo')
                    ->label('Paralelo')
                    ->sortable(),

                Tables\Columns\TextColumn::make('porcentaje_asistencia')
                    ->label('Asistencia (%)')
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('habilitado')
                    ->label('Habilitado')
                    ->sortable(),

                // Agrega columnas del Tutor aquí si deseas mostrar en la tabla
                Tables\Columns\TextColumn::make('primer_nombre_tutor')
                    ->label('Primer Nombre del Tutor')
                    ->sortable(),

                Tables\Columns\TextColumn::make('primer_apellido_tutor')
                    ->label('Primer Apellido del Tutor')
                    ->sortable(),

                Tables\Columns\TextColumn::make('ci_tutor')
                    ->label('CI del Tutor')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Aquí puedes agregar filtros si es necesario
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
            // Aquí puedes agregar relaciones si es necesario
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
