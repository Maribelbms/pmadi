<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DirectorResource\Pages;
use App\Filament\Resources\DirectorResource\RelationManagers;
use App\Models\Director;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\Text;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Table;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\Text as TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DirectorResource extends Resource
{
    protected static ?string $model = Director::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Sección: Datos del Director
                Section::make('Datos del Director')
                    ->schema([
                        TextInput::make('ci')
                            ->label('Cédula de Identidad')
                            ->required()
                            ->unique(ignorable: fn($record) => $record)
                            ->numeric()
                            ->minLength(6)
                            ->maxLength(10),

                        TextInput::make('primer_nombre')
                            ->label('Primer Nombre')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('segundo_nombre')
                            ->label('Segundo Nombre')
                            ->maxLength(255),

                        TextInput::make('primer_apellido')
                            ->label('Primer Apellido')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('segundo_apellido')
                            ->label('Segundo Apellido')
                            ->maxLength(255),

                        TextInput::make('telefono')
                            ->label('Teléfono')
                            ->nullable()
                            ->tel()
                            ->maxLength(15),

                            BelongsToSelect::make('unidad_educativa_id')
                            ->label('Unidad Educativa')
                            ->relationship('unidadEducativa', 'nombre_unidad') // Relación y columna correcta
                            ->required()
                            ->rule('exists:unidades_educativas,id_unidad_educativa')
                            ->placeholder('Selecciona una unidad educativa'),

                    ])

                    ->columns(2),

                // Sección: Datos del Usuario
                Section::make('Datos del Usuario')
                    ->schema([
                        TextInput::make('user.email')
                            ->label('Correo Electrónico')
                            ->required()
                            ->email()
                            ->unique('users', 'email') // Valida que no exista ya en la tabla `users`
                            ->placeholder('Ingresa el correo del director'),

                        TextInput::make('user.password')
                            ->label('Contraseña')
                            ->required()
                            ->password()
                            ->minLength(8)
                            ->placeholder('Ingresa una contraseña segura'),
                    ])
                    ->columns(2),

                // Estado Activo
                Toggle::make('activo')
                    ->label('¿Activo?')
                    ->default(true),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ci')->label('Cédula'),
                Tables\Columns\TextColumn::make('primer_nombre')->label('Nombre'),
                Tables\Columns\TextColumn::make('primer_apellido')->label('Apellido'),
                Tables\Columns\TextColumn::make('email')->label('Correo Electrónico'),
                BooleanColumn::make('activo')->label('Activo'),
                Tables\Columns\TextColumn::make('unidadEducativa.nombre')->label('Unidad Educativa'),

            ])
            ->filters([
                Filter::make('activo')->label('Activos')->query(fn(Builder $query) => $query->where('activo', true)),
                Filter::make('inactivos')->label('Inactivos')->query(fn(Builder $query) => $query->where('activo', false)),

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
            'index' => Pages\ListDirectors::route('/'),
            'create' => Pages\CreateDirector::route('/create'),
            'edit' => Pages\EditDirector::route('/{record}/edit'),
        ];
    }
}
