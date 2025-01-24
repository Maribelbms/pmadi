<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EducationalUserResource\Pages;
use App\Filament\Resources\EducationalUserResource\RelationManagers;
use App\Models\EducationalUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use App\Models\UnidadEducativa;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EducationalUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $label = 'Usuarios de Unidades Educativas';
    protected static ?string $pluralLabel = 'Usuarios de Unidades Educativas';
    protected static ?string $navigationLabel = 'Usuarios de Unidades Educativas';
    protected static ?string $navigationGroup = 'Usuarios';
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                TextInput::make('password')
                    ->password()
                    ->required(fn($livewire) => $livewire instanceof Pages\CreateEducationalUser)
                    ->dehydrated(fn($state) => filled($state)),
                Select::make('role_id')
                    ->label('Rol')
                    ->options([
                        3 => 'Profesor',
                        4 => 'Director',
                    ])
                    ->required()
                    ->reactive() // Hace que el campo sea dinámico
                    ->afterStateUpdated(function ($state, $set) {
                        // Limpia campos relacionados al cambiar el rol
                        $set('unidad_educativa_id', null);
                        $set('unidades_educativas', null);
                    }),
                Select::make('unidad_educativa_id')
                    ->label('Unidad Educativa')
                    ->options(fn() => UnidadEducativa::pluck('nombre_unidad', 'id_unidad_educativa'))
                    ->nullable()
                    ->required(),

                Select::make('unidades_educativas')
                    ->label('Unidades Educativas')
                    ->options(fn() => UnidadEducativa::pluck('nombre_unidad', 'id_unidad_educativa'))
                    ->multiple()
                    ->nullable()
                    ->visible(fn($get) => $get('role_id') === 4), // Visible solo para Profesores
                Toggle::make('active')->label('Activo')->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nombre')->sortable()->searchable(),
                TextColumn::make('email')->label('Correo Electrónico')->sortable()->searchable(),
                BadgeColumn::make('roles.name')
                    ->label('Roles')
                    ->colors([
                        'primary',
                    ]),
                // TextColumn::make('unidadEducativa.nombre_unidad')
                //     ->label('Unidad Educativa (Director)')
                //     ->visible(fn($record) => $record->role_id === 5), // Solo para Directores
                // TextColumn::make('unidadesEducativas.nombre_unidad')
                //     ->label('Unidades Educativas (Profesor)')
                //     ->visible(fn($record) => $record->role_id === 4), // Solo para Profesores
                BooleanColumn::make('active')->label('Activo'),
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
            'index' => Pages\ListEducationalUsers::route('/'),
            'create' => Pages\CreateEducationalUser::route('/create'),
            'edit' => Pages\EditEducationalUser::route('/{record}/edit'),
        ];
    }
}
