<?php

namespace App\Filament\Actions;

use App\Models\Association;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class AssociateUsersToAssociationAction extends BulkAction
{
    private Collection $users;

    public static function getDefaultName(): ?string
    {
        return 'associate-users-to-association';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Associa utenti a un\'associazione')
            ->modalHeading('Associa utenti a un\'associazione')
            ->modalSubmitActionLabel('Associa');

        $self = $this;

        $this->form(function ($livewire) use ($self) {
            $self->users = $livewire->getSelectedTableRecords();
            $users = $self->users;

            $options = Association::whereDoesntHave('users', function ($query) use ($users) {
                $query->whereIn('users.id', $users->pluck('id'));
            })->pluck('name', 'id')->toArray();

            $has_association = count($options) > 0;

            if (!$has_association)
                $self->modalSubmitAction(false);

            return $has_association ?
                [
                    Select::make('association_id')
                        ->label('Associazione')
                        ->options($options)
                        ->searchable()
                        ->required()
                ]
                : [
                    Placeholder::make('associazione')
                        ->label('Associazione')
                        ->content('Nessuna associazione disponibile per l\'associazione selezionata.'),
                ];
        });

        $this
            ->action(function (array $data) use ($self) {
                $users = $self->users;
                $association = Association::find($data['association_id']);
                $association->users()->attach($users);

                Notification::make()
                    ->title('Utenti associati')
                    ->body('Gli utenti sono stati associati con successo all\'associazione selezionata.')
                    ->success()
                    ->send();
            });
    }
}
