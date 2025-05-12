<?php

namespace App\Filament\Resources\BoardgameResource\Pages;

use App\Filament\Resources\BoardgameResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBoardgame extends ViewRecord
{
    protected static string $resource = BoardgameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
