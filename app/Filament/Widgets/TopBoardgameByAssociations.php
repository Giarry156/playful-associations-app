<?php

namespace App\Filament\Widgets;

use App\Models\Association;
use App\Models\Game;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class TopBoardgameByAssociations extends BaseWidget
{
    protected static ?string $heading = "Gioco più giocato per ogni associazione";
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        $counts = DB::table('games')
            ->select('association_id', 'boardgame_id', DB::raw('COUNT(*) as games_count'))
            ->groupBy('association_id', 'boardgame_id');

        $maxCounts = DB::table(DB::raw("({$counts->toSql()}) as counts"))
            ->mergeBindings($counts)
            ->select('association_id', DB::raw('MAX(games_count) as games_count'))
            ->groupBy('association_id');

        return $table
            ->query(
                Association::query()
                    ->joinSub($counts, 'c', function ($join) {
                        $join->on('associations.id', '=', 'c.association_id');
                    })
                    ->joinSub($maxCounts, 'mc', function ($join) {
                        $join->on('c.association_id', '=', 'mc.association_id')
                            ->on('c.games_count', '=', 'mc.games_count');
                    })
                    ->join('boardgames as b', 'b.id', '=', 'c.boardgame_id')
                    ->select(
                        'associations.id as id',
                        'associations.name as association_name',
                        'b.id as boardgame_id',
                        'b.name as boardgame_name',
                        'c.games_count'
                    )
            )
            ->columns([
                Tables\Columns\TextColumn::make('association_id')
                    ->label('ID Associazione')
                    ->hidden(),
                Tables\Columns\TextColumn::make('association_name')
                    ->label('Associazione')
                    ->sortable(),
                Tables\Columns\TextColumn::make('boardgame_name')
                    ->label('Gioco più giocato')
                    ->sortable(),
                Tables\Columns\TextColumn::make('games_count')
                    ->label('Partite totali')
                    ->sortable()
            ])
            ->defaultSort('games_count', 'desc');
    }
}
