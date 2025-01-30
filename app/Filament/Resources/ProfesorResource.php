<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfesorResource\Pages;
use App\Models\Profesor;
use App\Models\ProfesorUnidad;
use App\Models\UnidadEducativa;
use App\Models\User;
use Filament\Forms;
use Illuminate\Support\Facades\Auth;
use App\Models\Director;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;

class ProfesorResource extends Resource
{
    protected static ?string $model = Profesor::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Section::make('Datos del Profesor')
                    ->schema([
                        TextInput::make('ci')
                            ->label('Cédula de Identidad')
                            ->required(),
                        TextInput::make('primer_nombre')
                            ->label('Primer Nombre')
                            ->required(),
                        TextInput::make('segundo_nombre')
                            ->label('Segundo Nombre'),
                        TextInput::make('primer_apellido')
                            ->label('Primer Apellido')
                            ->required(),
                        TextInput::make('segundo_apellido')
                            ->label('Segundo Apellido'),
                        TextInput::make('telefono')
                            ->label('Teléfono'),
                    ])
                    ->columns(2),

                Section::make('Datos de Usuario')
                    ->schema([
                        TextInput::make('email')
                            ->label('Correo Electrónico')
                            ->unique('users', 'email')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->label('Contraseña')
                            ->password()
                            ->required()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                    ])
                    ->columns(2),

                Section::make('Asignación de Unidad Educativa')
                    ->schema([
                        Forms\Components\Hidden::make('unidad_educativa_id')
                    ->default(function () {
                        return Director::where('user_id', Auth::id())->value('unidad_educativa_id');
                    }),


                        TextInput::make('nivel')
                            ->label('Nivel')
                            ->default('INICIAL')
                            ->disabled(),

                            Forms\Components\Select::make('curso')
                            ->label('Curso')
                            ->options([
                                '1' => 'PRIMERA SECCION',
                                '2' => 'SEGUNDA SECCION',
                            ]),

                        TextInput::make('paralelo')
                            ->label('Paralelo')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('ci')->label('CI'),
                TextColumn::make('primer_nombre')->label('Nombre'),
                TextColumn::make('primer_apellido')->label('Apellido'),
                TextColumn::make('user.email')->label('Correo'),
                TextColumn::make('profesorUnidad.nivel')->label('Nivel'),
                TextColumn::make('profesorUnidad.curso')->label('Curso'),
                TextColumn::make('profesorUnidad.paralelo')->label('Paralelo'),
            ])
            ->filters([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfesors::route('/'),
            'create' => Pages\CreateProfesor::route('/create'),
            'edit' => Pages\EditProfesor::route('/{record}/edit'),
        ];
    }
}
