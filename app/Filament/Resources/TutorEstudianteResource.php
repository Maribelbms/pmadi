<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TutorEstudianteResource\Pages;
use App\Filament\Resources\TutorEstudianteResource\RelationManagers;
use App\Models\TutorEstudiante;
use App\Models\Tutor;
use App\Models\Estudiante;
use App\Models\Gestion;
use App\Models\ProfesorUnidad;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;

use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;


class TutorEstudianteResource extends Resource
{
    protected static ?string $model = Estudiante::class;

    protected static ?string $navigationGroup = 'Registro';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $pluralLabel = 'Estudiante y Tutor';
    protected static ?string $label = 'Estudiante';

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
                            Forms\Components\Select::make('expedido_tutor')
                                ->label('Expedición del CI del Tutor')
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
                                ->required()
                                ->disabled(fn($get) => $get('ci_tutor') && Tutor::where('ci_tutor', $get('ci_tutor'))->exists()),


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


                            // Forms\Components\Select::make('gestion_id')
                            //     ->label('Gestión')
                            //     ->relationship('gestion', 'nombre_gestion')
                            //     ->required(),
                        ]),
                    // ->model(Tutor::class),


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
                                ->maxLength(30)
                                ->numeric()
                                ->unique('estudiantes', 'ci')
                                ->required(),
                            // ->rule( // Agregamos una regla de validación personalizada
                            //     Rule::unique('estudiantes', 'ci')->whereNull('deleted_at')
                            // ),

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
                                ->default(fn() => ProfesorUnidad::where('profesor_id', Auth::user()->profesor->id ?? null)
                                    ->value('nivel'))
                                ->disabled()
                                ->required(),

                            Forms\Components\TextInput::make('curso')
                                ->label('Curso')
                                ->default(
                                    fn() =>
                                    collect([
                                        '1' => 'PRIMERA SECCIÓN',
                                        '2' => 'SEGUNDA SECCIÓN',
                                    ])->get(ProfesorUnidad::where('profesor_id', Auth::user()->profesor->id ?? null)
                                            ->value('curso'), 'SIN ASIGNACIÓN') // Si no encuentra valor, muestra "SIN ASIGNACIÓN"
                                )
                                ->disabled()
                                ->required(),


                            Forms\Components\TextInput::make('paralelo')
                                ->label('Paralelo')
                                ->default(fn() => ProfesorUnidad::where('profesor_id', Auth::user()->profesor->id ?? null)
                                    ->value('paralelo'))
                                ->disabled()
                                ->required(),

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
    

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $profesor = $user->profesor;

        // Si el usuario no tiene un profesor asociado, evitar que vea registros
        if (!$profesor) {
            return parent::getEloquentQuery()->whereNull('id_estudiante');
        }

        return parent::getEloquentQuery()

            ->withNombreCompleto()
            ->whereHas('unidadEducativa', function ($query) use ($profesor) {
                $query->where('id_unidad_educativa', $profesor->unidad_educativa_id);
            })
            ->whereHas('profesorUnidad', function ($query) use ($profesor) {
                $query->where('profesor_id', $profesor->id)
                    ->whereColumn('curso', 'estudiantes.curso')
                    ->whereColumn('paralelo', 'estudiantes.paralelo');
            })
            ->with([
                'tutor' => function ($query) {
                    $query->select(
                        'id_tutor',
                        'ci_tutor',
                        DB::raw("CONCAT(
                        primer_nombre_tutor, ' ', 
                        COALESCE(segundo_nombre_tutor, ''), ' ', 
                        primer_apellido_tutor, ' ', 
                        COALESCE(segundo_apellido_tutor, ''), ' ',
                        COALESCE(tercer_apellido_tutor, '')
                    ) AS nombre_completo_tutor")
                    );

                }

            ]);
    }





    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre_completo')
                    ->label('Nombre Completo Estudiante'),


                Tables\Columns\TextColumn::make('ci')
                    ->label('CI del Estudiante')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('curso')
                    ->label('Curso')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('paralelo')
                    ->label('Paralelo')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('tutor.nombre_completo_tutor')
                    ->label('Nombre Completo Tutor'),
                Tables\Columns\TextColumn::make('tutor.ci_tutor')
                    ->label('CI del Tutor')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('gestion.nombre_gestion')
                //     ->label('Gestión')
                //     ->sortable(),
                Tables\Columns\BooleanColumn::make('habilitado')
                    ->label('Habilitado')
                    ->colors([
                        'success' => 'si',
                        'danger' => 'no',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Fecha de Creación')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('verDetalles')
                    ->label('Ver Detalles')
                    ->icon('heroicon-o-eye')
                    ->modalHeading('Detalles del Estudiante y Tutor')
                    ->modalWidth('lg')
                    ->modalSubmitAction(false)
                    ->modalContent(fn($record) => view('filament.modals.detalle-estudiante', [
                        'estudiante' => $record->load('tutor') // Cargar la relación si aún no está cargada
                    ]))
                ,
                Tables\Actions\DeleteAction::make()
                    ->label('Eliminar')
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation(),

            ])
            ->filters([
                //
            ])
            // ->actions([
            //     Tables\Actions\EditAction::make(),
            // ])
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
