<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameResource\Pages;
use App\Filament\Resources\GameResource\RelationManagers;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GameResource extends Resource
{
    protected static ?string $model = Game::class;
    protected static ?string $navigationLabel = 'Partite';
    protected static ?string $modelLabel = 'Partita';
    protected static ?string $pluralModelLabel = 'Partite';
    protected static ?string $navigationGroup = 'Anagrafiche';
    protected static ?string $title = 'Partite';
    protected static ?string $slug = 'games';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'ri-sword-line';

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
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Creato il'),
                Tables\Columns\TextColumn::make('association.name')->label('Associazione')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('boardgame.name')->label('Gioco')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('users_count')->counts("users")
                    ->label('Giocatori'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('id')->label('ID'),
                TextEntry::make('association.name')->label('Associazione')
                    ->url(fn($record): string => AssociationResource::getUrl('view', ["record" => $record->association_id])),
                TextEntry::make('boardgame.name')->label('Gioco')
                    ->url(fn($record): string => BoardgameResource::getUrl('view', ["record" => $record->boardgame_id])),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\UsersRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGames::route('/'),
            'create' => Pages\CreateGame::route('/create'),
            'view' => Pages\ViewGame::route('/{record}'),
            'edit' => Pages\EditGame::route('/{record}/edit'),
        ];
    }
}
