<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProfesorResource\Pages;
use App\Filament\Resources\ProfesorResource\RelationManagers;
use App\Models\Profesor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Resources\Resource;
use Filament\Tables;
use App\Models\UnidadEducativa;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProfesorResource extends Resource
{
    protected static ?string $model = Profesor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('ci')
                ->label('Cédula de Identidad')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(10),

            TextInput::make('primer_nombre')
                ->label('Primer Nombre')
                ->required()
                ->maxLength(255),

            TextInput::make('primer_apellido')
                ->label('Primer Apellido')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Correo Electrónico')
                ->required()
                ->email()
                ->unique(ignoreRecord: true),

            TextInput::make('telefono')
                ->label('Teléfono')
                ->nullable()
                ->tel()
                ->maxLength(15),

            // Repetidor para asignaciones
            Repeater::make('asignaciones')
    ->label('Asignaciones')
    ->schema([
        Select::make('unidad_educativa_id')
                ->label('Unidad Educativa')
                ->options(UnidadEducativa::all()->pluck('nombre_unidad', 'id_unidad_educativa'))
                ->searchable()
                ->required(),


        TextInput::make('nivel')
            ->label('Nivel Educativo')
            ->required(),

        TextInput::make('curso')
            ->label('Curso')
            ->required(),

        TextInput::make('paralelo')
            ->label('Paralelo')
            ->required(),
    ])
    ->collapsible()
    ->defaultItems(1),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                    Tables\Columns\TextColumn::make('ci')->label('C.I.'),
                    Tables\Columns\TextColumn::make('primer_nombre')->label('Primer Nombre'),
                    Tables\Columns\TextColumn::make('primer_apellido')->label('Primer Apellido'),
                    Tables\Columns\TextColumn::make('email')->label('Correo Electrónico'),
                    Tables\Columns\BooleanColumn::make('activo')->label('Activo'),

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
            'index' => Pages\ListProfesors::route('/'),
            'create' => Pages\CreateProfesor::route('/create'),
            'edit' => Pages\EditProfesor::route('/{record}/edit'),
        ];
    }
}
