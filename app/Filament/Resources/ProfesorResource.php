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
                // Datos para la tabla `users`
            // Forms\Components\TextInput::make('name')
            // ->label('Nombre Completo')
            // ->required(),
        Forms\Components\TextInput::make('email')
            ->label('Correo Electrónico')
            ->email()
            ->required(),
        Forms\Components\TextInput::make('password')
            ->label('Contraseña')
            ->password()
            ->required()
            ->minLength(8),
        
        // Datos para la tabla `profesores`
        Forms\Components\TextInput::make('ci')
            ->label('Cédula de Identidad')
            ->required()
            ->unique(ignoreRecord: true),
        Forms\Components\TextInput::make('primer_nombre')
            ->required(),
        Forms\Components\TextInput::make('segundo_nombre'),
        Forms\Components\TextInput::make('primer_apellido')
            ->required(),
        Forms\Components\TextInput::make('segundo_apellido'),
        Forms\Components\TextInput::make('telefono')
            ->label('Teléfono'),
        Forms\Components\Toggle::make('activo')
            ->label('Activo')
            ->default(true),
        
        // Datos para la tabla `profesor_unidad`
        Forms\Components\Select::make('unidad_educativa_id' )
            ->relationship('unidadEducativa', 'nombre_unidad')
            ->label('Unidad Educativa')
            ->required(),
        Forms\Components\TextInput::make('nivel')
            ->label('Nivel Educativo')
            ->required(),
        Forms\Components\TextInput::make('curso')
            ->label('Curso')
            ->required(),
        Forms\Components\TextInput::make('paralelo')
            ->label('Paralelo')
            ->required(),
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
