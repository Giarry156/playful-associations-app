<?php

namespace App\Filament\Widgets;

use App\Models\Boardgame;
use App\Models\Game;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $topBoardgame = Game::getTopBoardgamePlayed();
        $currentYearGamesAvg = Game::getAveragePerYear();
        $lastYearGamesAvg = Game::getAveragePerYear(now()->subYear());
        $differencePercentageGamesAvg = (($currentYearGamesAvg - $lastYearGamesAvg) / $lastYearGamesAvg) * 100;
        $differencePercentageGamesAvgColor = $differencePercentageGamesAvg > 0 ? 'success' : 'danger';
        $differencePercentageGamesAvgIcon = $differencePercentageGamesAvg > 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down';
        $currentMonthGames = Game::getMonthCount();
        $lastMonthGames = Game::getMonthCount(now()->subMonth());
        $differencePercentageGames = (($currentMonthGames - $lastMonthGames) / $lastMonthGames) * 100;
        $differencePercentageGamesColor = $differencePercentageGames > 0 ? 'success' : 'danger';
        $differencePercentageGamesIcon = $differencePercentageGames > 0 ? 'heroicon-o-arrow-trending-up' : 'heroicon-o-arrow-trending-down';

        return [
            Stat::make('Gioco più giocato di sempre', $topBoardgame->name)
                ->description('Totale partite: ' . $topBoardgame->games_count)
                ->icon('heroicon-o-cube')
                ->color('success'),
            Stat::make('Numero medio di partite dell\'anno', $currentYearGamesAvg)
                ->description('Rispetto all\'anno scorso: ' . Number::percentage($differencePercentageGamesAvg, 2))
                ->descriptionIcon($differencePercentageGamesAvgIcon)
                ->descriptionColor($differencePercentageGamesAvgColor)
                ->icon('heroicon-o-cube')
                ->chart(Game::getYearCountPerMonth())
                ->color($differencePercentageGamesAvgColor),
            Stat::make('Numero di partite del mese', $currentMonthGames)
                ->description('Rispetto al mese scorso: ' . Number::percentage($differencePercentageGames, 2))
                ->descriptionIcon($differencePercentageGamesIcon)
                ->descriptionColor($differencePercentageGamesColor)
                ->icon('heroicon-o-cube'),
        ];
    }
}
