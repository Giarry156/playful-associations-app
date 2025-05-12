<?php

namespace App\Filament\Resources\BoardgameResource\Pages;

use App\Filament\Resources\BoardgameResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBoardgame extends CreateRecord
{
    protected static string $resource = BoardgameResource::class;
}
