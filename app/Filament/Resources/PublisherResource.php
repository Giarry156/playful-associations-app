<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublisherResource\Pages;
use App\Filament\Resources\PublisherResource\RelationManagers;
use App\Models\Publisher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PublisherResource extends Resource
{
    protected static ?string $model = Publisher::class;
    protected static ?string $navigationLabel = 'Editori';
    protected static ?string $modelLabel = 'Editore';
    protected static ?string $pluralModelLabel = 'Editori';
    protected static ?string $navigationGroup = 'Anagrafiche';
    protected static ?string $title = 'Editori';
    protected static ?string $slug = 'publishers';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'fluentui-megaphone-loud-16-o';

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
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('website')->label('Sito Web')->getStateUsing(fn(Publisher $record) {
                    return $record->website ? "<a href='{$record->website}' target='_blank' class='text-blue-500 hover:underline'>{$record->website}</a>" : null;
                })
                Tables\Columns\TextColumn::make('address')->label('Indirizzo')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('city')->label('Città')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Creato il'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPublishers::route('/'),
            'create' => Pages\CreatePublisher::route('/create'),
            'view' => Pages\ViewPublisher::route('/{record}'),
            'edit' => Pages\EditPublisher::route('/{record}/edit'),
        ];
    }
}
