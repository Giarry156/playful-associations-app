<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PublisherResource\Pages;
use App\Filament\Resources\PublisherResource\RelationManagers;
use App\Models\Publisher;
use Filament\Actions\ActionGroup;
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
                Tables\Columns\TextColumn::make('website')->label('Sito Web')->getStateUsing(function (Publisher $record): string {
                    return $record->website ? '<a class=":group-hover/link:underline group-focus-visible/link:underline text-sm leading-6 text-gray-950 dark:text-white" href="' . $record->website . '" target="_blank">Apri sito web</a>' : '';
                })->html(),
                Tables\Columns\TextColumn::make('address')->label('Indirizzo')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('city')->label('Città')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Creato il'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('create-game')
                        ->icon('heroicon-o-plus-circle')
                        ->label("Pubblica gioco")
                        ->action(function (Publisher $publisher, array $data) {
                            $boardgame = $publisher->boardgames()->create([
                                'name' => $data['name'],
                                'number_of_players' => $data['number_of_players'],
                                'playtime' => $data['playtime']
                            ]);

                            return redirect(BoardgameResource::getUrl('view', [
                                'record' => $boardgame->id,
                            ]));
                        })
                        ->form([
                            Forms\Components\TextInput::make('name')->label('Nome gioco')->required(),
                            Forms\Components\TextInput::make('number_of_players')->label('Numero di giocatori')->numeric(),
                            Forms\Components\TextInput::make('playtime')->label('Tempo di gioco')->numeric(),
                        ])
                ])
                    ->label('Opzioni')
                    ->button()
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
