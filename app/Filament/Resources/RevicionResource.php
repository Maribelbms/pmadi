<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RevicionResource\Pages;
use App\Filament\Resources\RevicionResource\RelationManagers;
use App\Models\Revicion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RevicionResource extends Resource
{
    protected static ?string $model = Revicion::class;
    protected static ?string $navigationGroup = 'Gestión de Revisiones';
    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $pluralLabel = 'Estudiantes y Tutores';
    protected static ?string $label = 'Revisión';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();
        $director = $user->director;

        if ($director) {
            return parent::getEloquentQuery()
                ->where('estado_registro', 'en revision')
                ->whereHas('estudiante', function ($query) use ($director) {
                    $query->where('unidad_educativa_id', $director->unidad_educativa_id);
                });
        }

        return parent::getEloquentQuery();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('estudiante.primer_nombre')
                ->label('Estudiante')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('tutor.primer_nombre_tutor')
                ->label('Tutor')
                ->sortable()
                ->searchable(),

            Tables\Columns\TextColumn::make('estudiante.nivel')
                ->label('Nivel')
                ->sortable(),

            Tables\Columns\TextColumn::make('estudiante.curso')
                ->label('Curso')
                ->sortable(),

            Tables\Columns\TextColumn::make('estado_registro')
                ->label('Estado')
                ->badge()
                ->colors([
                    'warning' => 'en revision',
                    'success' => 'validado',
                    'primary' => 'enviado_pmadi',
                ]),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Fecha de Registro')
                ->dateTime()
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('estado_registro')
                ->label('Estado de Revisión')
                ->options([
                    'en_revision' => 'En Revisión',
                    'validado' => 'Validado',
                    'enviado_pmadi' => 'Enviado a PMADI',
                ]),

            Tables\Filters\SelectFilter::make('estudiante.nivel')
                ->label('Filtrar por Nivel')
                ->relationship('estudiante', 'nivel'),

            Tables\Filters\SelectFilter::make('estudiante.curso')
                ->label('Filtrar por Curso')
                ->relationship('estudiante', 'curso'),
            ])
            
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            // ->bulkActions([
            //     Tables\Actions\BulkActionGroup::make([
            //         Tables\Actions\DeleteBulkAction::make(),
            //     ]),
            // ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('enviar_pmadi')
                    ->label('Enviar a PMADI')
                    ->icon('heroicon-o-paper-airplane')
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        foreach ($records as $record) {
                            $record->update(['estado_registro' => 'enviado_pmadi']);
                        }
                    }),
            ]);;
    }

    public static function getRelations(): array
    {
        return [
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRevicions::route('/'),
            // 'create' => Pages\CreateRevicion::route('/create'),
            'edit' => Pages\EditRevicion::route('/{record}/edit'),
        ];
    }
}
