<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EstudianteProfesorResource\Pages;
use App\Filament\Resources\EstudianteProfesorResource\RelationManagers;
use App\Models\Estudiante;
use App\Models\EstudianteGestion;
use App\Models\ProfesorUnidad;
use App\Models\UnidadEducativa;
use App\Models\Gestion;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use Livewire\Livewire;

class EstudianteProfesorResource extends Resource
{
    protected static ?string $model = Estudiante::class;

    protected static ?string $navigationGroup = 'Registro';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $pluralLabel = 'Estudiantes';
    protected static ?string $label = 'Estudiante';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('primer_nombre')
                        ->required()
                        ->label('Primer Nombre'),
                    TextInput::make('segundo_nombre')
                        ->label('Segundo Nombre'),
                    TextInput::make('primer_apellido')
                        ->required()
                        ->label('Primer Apellido'),
                    TextInput::make('segundo_apellido')
                        ->label('Segundo Apellido'),
                    TextInput::make('ci')
                        ->required()
                        ->label('C.I.')
                        ->unique(ignoreRecord: true),
                    Select::make('expedido')
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
                    Select::make('sexo')
                        ->label('Sexo')
                        ->options([
                            'M' => 'Masculino',
                            'F' => 'Femenino',
                        ])
                        ->required(),
                    TextInput::make('rude')
                        ->label('RUDE')
                        ->unique(ignoreRecord: true),
                    TextInput::make('nombre_unidad')
                        ->label('Unidad Educativa')
                        ->default(function () {
                            $profesorId = auth()->user()->profesor->id ?? null;

                            // Buscar la unidad educativa a través de la relación
                            $unidadEducativa = ProfesorUnidad::where('profesor_id', $profesorId)
                                ->with('unidadEducativa') // Relación con UnidadEducativa
                                ->first();

                            return $unidadEducativa?->unidadEducativa?->nombre_unidad ?? 'No asignado';
                        })
                        ->disabled()
                        ->required(),

                    TextInput::make('nivel')
                        ->label('Nivel')
                        ->default(fn() => ProfesorUnidad::where('profesor_id', auth()->user()->profesor->id ?? null)
                            ->value('nivel'))
                        ->disabled()
                        ->required(),
                    TextInput::make('curso')
                        ->label('Curso')
                        ->default(fn() => ProfesorUnidad::where('profesor_id', auth()->user()->profesor->id ?? null)
                            ->value('curso'))
                        ->disabled()
                        ->required(),
                    TextInput::make('paralelo')
                        ->label('Paralelo')
                        ->default(fn() => ProfesorUnidad::where('profesor_id', auth()->user()->profesor->id ?? null)
                            ->value('paralelo'))
                        ->disabled()
                        ->required(),
                    // Campo porcentaje de asistencia
                    TextInput::make('porcentaje_asistencia')
                        ->label('Porcentaje de Asistencia')
                        ->numeric()
                        ->minValue(0)
                        ->maxValue(100)
                        ->step(0.01)
                        ->required()
                        ->reactive()
                        ->afterStateUpdated(function ($state, $set) {
                            // Actualiza el campo habilitado según el porcentaje
                            $set('habilitado', $state >= 51 ? 'si' : 'no');
                        }),
                ]),
            ]);
    }
    public static function getEloquentQuery(): Builder
    {

        return parent::getEloquentQuery()
            ->withNombreCompleto()
            ->with('tutorActivo.tutor');
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre_completo')
                    ->label('Nombre Completo')
                    ->sortable(['nombre_completo'])
                    ->searchable(),
                TextColumn::make('ci')->label('C.I.'),
                TextColumn::make('expedido')->label('Expedido')->sortable()->searchable(),
                TextColumn::make('sexo')->label('Género')->sortable()->searchable(),
                TextColumn::make('unidadEducativaEstudiante.nombre_unidad')->label('Unidad Educativa')->sortable()->searchable(),
                // TextColumn::make('estudianteGestion.nivel')
                //     ->label('Nivel')
                //     ->sortable()
                //     ->searchable(),
                TextColumn::make('estudianteGestion.curso')
                    ->label('Curso')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('estudianteGestion.paralelo')
                    ->label('Paralelo')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('estudianteGestion.habilitado')
                    ->label('Habilitado')
                    ->colors([
                        'success' => fn($state) => $state === true,  // Verde para habilitado
                        'danger' => fn($state) => $state === false, // Rojo para no habilitado
                    ])
                    ->formatStateUsing(fn($state) => $state === true ? 'Sí' : 'No'), // Mostrar "Sí" o "No"
                TextColumn::make('tutorActivo')
                    ->label('Estado del Tutor')
                    ->formatStateUsing(fn($record) => $record->tutorActivo ? '🟢 Asignado' : '🔴 No Asignado')
                    ->color(fn($record) => $record->tutorActivo ? 'green' : 'red')
                    ->default('🔴 No Asignado'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('Asignar Tutor')
                    ->icon('heroicon-o-user')
                    ->button()
                    ->url(fn ($record) => route('asignar-tutor', $record->id_estudiante)),
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
            'index' => Pages\ListEstudianteProfesors::route('/'),
            'create' => Pages\CreateEstudianteProfesor::route('/create'),
            'edit' => Pages\EditEstudianteProfesor::route('/{record}/edit'),
        ];
    }



}

