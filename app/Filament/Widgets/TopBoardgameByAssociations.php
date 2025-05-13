<?php

namespace App\Filament\Widgets;

use App\Models\Association;
use App\Models\Game;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopBoardgameByAssociations extends BaseWidget
{
    protected static ?string $heading = "Gioco èiù giocato per Associazione";

    public function table(Table $table): Table
    {
        $topBoardgameByAssociations = Game::getTopBoardgamePlayedByAssociations();

        return $table
            ->query(
                Association::query()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Associazione')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('topBoardgame')->getStateUsing(function (Association $association) use ($topBoardgameByAssociations) {
                    return $topBoardgameByAssociations->firstWhere('association.id', $association->id)->boardgame->name ?? 'N/A';
                })
                    ->label('Gioco più giocato')
                    ->sortable(),
                Tables\Columns\TextColumn::make('gamesCount')->getStateUsing(function (Association $association) use ($topBoardgameByAssociations) {
                    return $topBoardgameByAssociations->firstWhere('association.id', $association->id)->games_count ?? 0;
                })
                    ->label('Partite totali')
                    ->sortable()
            ]);
    }
}
