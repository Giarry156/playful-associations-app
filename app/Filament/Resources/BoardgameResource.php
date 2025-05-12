<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BoardgameResource\Pages;
use App\Filament\Resources\BoardgameResource\RelationManagers;
use App\Models\Boardgame;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BoardgameResource extends Resource
{
    protected static ?string $model = Boardgame::class;
    protected static ?string $navigationLabel = 'Giochi da tavolo';
    protected static ?string $modelLabel = 'Gioco da tavolo';
    protected static ?string $pluralModelLabel = 'Giochi da tavolo';
    protected static ?string $navigationGroup = 'Anagrafiche';
    protected static ?string $title = 'Giochi da tavolo';
    protected static ?string $slug = 'boardgames';
    protected static ?int $navigationSort = 3;
    protected static bool $hasTitleCaseModelLabel = false;
    protected static ?string $navigationIcon = 'far-chess-pawn';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('number_of_players')->label('Numero di giocatori'),
                Tables\Columns\TextColumn::make('playtime')->label('Tempo di gioco'),
                Tables\Columns\TextColumn::make('publisher.name')->label('Editore')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Creato il')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListBoardgames::route('/'),
            'create' => Pages\CreateBoardgame::route('/create'),
            'view' => Pages\ViewBoardgame::route('/{record}'),
            'edit' => Pages\EditBoardgame::route('/{record}/edit'),
        ];
    }
}
