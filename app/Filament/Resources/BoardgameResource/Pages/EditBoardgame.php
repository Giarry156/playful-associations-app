<?php

namespace App\Filament\Resources\BoardgameResource\Pages;

use App\Filament\Resources\BoardgameResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBoardgame extends EditRecord
{
    protected static string $resource = BoardgameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
