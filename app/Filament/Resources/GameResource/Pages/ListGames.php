<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use App\Models\Association;
use App\Models\Boardgame;
use App\Models\Game;
use App\Models\User;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Get;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class ListGames extends ListRecords
{
    protected static string $resource = GameResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create-game')
                ->modalSubmitAction(false)
                ->modalCancelAction(false)
                ->label('Nuova partita')
                ->form([
                    Wizard::make([
                        Wizard\Step::make('Associazione e gioco')
                            ->schema([
                                Select::make('association_id')
                                    ->label('Associazione')
                                    ->searchable()
                                    ->required()
                                    ->options(function () {
                                        return Association::all()->pluck('name', 'id')->toArray();
                                    })
                                    ->live(),
                                Select::make('boardgame_id')
                                    ->label('Gioco')
                                    ->searchable()
                                    ->required()
                                    ->options(function () {
                                        return Boardgame::all()->pluck('name', 'id')->toArray();
                                    })
                            ]),
                        Wizard\Step::make('Seleziona giocatori')
                            ->schema([
                                    Select::make('users')
                                        ->label('Giocatori')
                                        ->multiple()
                                        ->searchable()
                                        ->required()
                                        ->options(function (Get $get) {
                                            return User::whereHas('associations', function (Builder $builder) use ($get) {
                                                $builder->where('associations.id', $get('association_id'));
                                            })->pluck('name', 'id')->toArray();
                                        })
                                ]
                            )
                    ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                            <x-filament::button
                                type="submit"
                                size="sm"
                            >
                                Inserisci
                            </x-filament::button>
                        BLADE
                    )))
                ])
                ->action(function (array $data) {
                    $game = Game::create([
                        'association_id' => $data['association_id'],
                        'boardgame_id' => $data['boardgame_id']
                    ]);

                    $game->users()->attach($data['users']);

                    return redirect(GameResource::getUrl('view', [
                        'record' => $game->id,
                    ]));
                })
        ];
    }
}
