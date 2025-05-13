<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Filament\Resources\AssociationResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssociationsRelationManager extends RelationManager
{
    protected static string $relationship = 'associations';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return 'Associazioni';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return AssociationResource::table($table)
            ->recordUrl(fn(Model $record): string => AssociationResource::getUrl('view', ['record' => $record]));
    }
}
