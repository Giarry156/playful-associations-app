<?php

namespace App\Filament\Widgets;

use App\Models\Game;
use Filament\Widgets\ChartWidget;

class MonthGamesChart extends ChartWidget
{
    protected static ?string $heading = 'Partite dell\'anno';
    protected static string $color = 'info';
    protected int|string|array $columnSpan = 'full';
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        $data = Game::getYearCountPerMonth();

        return [
            'datasets' => [
                [
                    'label' => 'Partite dell\'anno',
                    'data' => $data,
                    'backgroundColor' => 'rgba(75, 192, 192, 0.2)',
                    'borderColor' => 'rgba(75, 192, 192, 1)',
                    'borderWidth' => 1,
                ],
            ],
            'labels' => [
                'Gennaio',
                'Febbraio',
                'Marzo',
                'Aprile',
                'Maggio',
                'Giugno',
                'Luglio',
                'Agosto',
                'Settembre',
                'Ottobre',
                'Novembre',
                'Dicembre'
            ]
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
