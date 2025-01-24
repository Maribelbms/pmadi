<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnidadEducativaResource\Pages;
use App\Filament\Resources\UnidadEducativaResource\RelationManagers;
use App\Models\UnidadEducativa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TextFilter;
use Filament\Tables\Filters\SelectFilter;

class UnidadEducativaResource extends Resource
{
    protected static ?string $model = UnidadEducativa::class;

    protected static ?string $navigationLabel = 'Unidades Educativas';
    protected static ?string $navigationGroup = 'Gestión de Unidades Educativas';
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre_unidad')
                    ->label('Nombre de la Unidad')
                    ->required()
                    ->maxLength(100),

                TextInput::make('codigo_sie')
                    ->label('Código SIE')
                    ->required()
                    ->maxLength(100),

                Select::make('turno')
                    ->label('Turno')
                    ->options([
                        'mañana' => 'Mañana',
                        'tarde' => 'Tarde',
                        'noche' => 'Noche',
                    ])
                    ->required(),

                Select::make('distrital_educacion')
                    ->label('Distrital de Educación')
                    ->options([
                        'el alto1' => 'El Alto 1',
                        'el alto2' => 'El Alto 2',
                        'el alto3' => 'El Alto 3',
                    ])
                    ->required(),

                Select::make('distrito')
                    ->label('Distrito')
                    ->options([
                        1 => '1',
                        2 => '2',
                        3 => '3',
                        4 => '4',
                        5 => '5',
                        6 => '6',
                        7 => '7',
                        8 => '8',
                        9 => '9',
                        10 => '10',
                        11 => '11',
                        12 => '12',
                        13 => '13',
                        14 => '14',
                    ])
                    ->required(),


                Textarea::make('direccion')
                    ->label('Dirección')
                    ->maxLength(300),

                Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'Activa' => 'Activa',
                        'Inactiva' => 'Inactiva',
                    ])
                    ->default('Activa'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre_unidad')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('codigo_sie')
                    ->label('Código SIE')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('turno')
                    ->label('Turno')
                    ->sortable(),

                TextColumn::make('distrital_educacion')
                    ->label('Distrital de Educación')
                    ->sortable(),

                TextColumn::make('distrito')
                    ->label('Distrito')
                    ->sortable(),

                TextColumn::make('direccion')
                    ->label('Dirección'),

                BadgeColumn::make('estado')
                    ->label('Estado')
                    ->colors([
                        'success' => 'Activa',
                        'danger' => 'Inactiva',
                    ]),
            ])
            ->filters([

                SelectFilter::make('estado')
                    ->label('Estado')
                    ->options([
                        'Activa' => 'Activa',
                        'Inactiva' => 'Inactiva',
                    ]),
                    
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
            'index' => Pages\ListUnidadEducativas::route('/'),
            'create' => Pages\CreateUnidadEducativa::route('/create'),
            'edit' => Pages\EditUnidadEducativa::route('/{record}/edit'),
        ];
    }
}
