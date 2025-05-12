<?php

namespace App\Filament\Resources\BoardgameResource\Pages;

use App\Filament\Resources\BoardgameResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBoardgames extends ListRecords
{
    protected static string $resource = BoardgameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
