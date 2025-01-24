<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TutorResource\Pages;
use App\Filament\Resources\TutorResource\RelationManagers;
use App\Models\Tutor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TutorResource extends Resource
{
    protected static ?string $model = Tutor::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('primer_nombre_tutor')
                    ->label('Primer Nombre del Tutor')
                    ->required(),
                Forms\Components\TextInput::make('segundo_nombre_tutor')
                    ->label('Segundo Nombre del Tutor')
                    ->nullable(),
                Forms\Components\TextInput::make('primer_apellido_tutor')
                    ->label('Primer Apellido del Tutor')
                    ->required(),
                Forms\Components\TextInput::make('ci_tutor')
                    ->label('CI del Tutor')
                    ->unique()
                    ->required(),
                Forms\Components\Select::make('expedido_tutor')
                    ->label('Expedido')
                    ->options([
                        'QR' => 'QR',
                        'LP' => 'La Paz',
                        'CB' => 'Cochabamba',
                        'SC' => 'Santa Cruz',
                        // Otros valores...
                    ])
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListTutors::route('/'),
            'create' => Pages\CreateTutor::route('/create'),
            'edit' => Pages\EditTutor::route('/{record}/edit'),
        ];
    }
}
