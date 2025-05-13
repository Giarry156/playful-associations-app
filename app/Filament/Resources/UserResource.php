<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Actions\AssociateUsersToAssociationAction;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationLabel = 'Utenti';
    protected static ?string $modelLabel = 'Utente';
    protected static ?string $pluralModelLabel = 'Utenti';
    protected static ?string $navigationGroup = 'Anagrafiche';
    protected static ?string $title = 'Utenti';
    protected static ?string $slug = 'users';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label('Nome')->required(),
                Forms\Components\TextInput::make('email')->label('E-mail')->required()->email(),
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->dehydrated(false)
                    ->visibleOn('create'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nome'),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable()
                    ->label('E-mail'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Creato il'),
                Tables\Columns\TextColumn::make('associations_count')
                    ->getStateUsing(function (User $user) {
                        return $user->associations()->count();
                    })
                    ->label('Numero di associazioni'),
            ])
            ->filters([
                Tables\Filters\Filter::make('not_in_associations')
                    ->label('Non in associazioni')
                    ->query(fn(Builder $query): Builder => $query->whereDoesntHave('associations')),
                Tables\Filters\SelectFilter::make('status')->label('Stato')
                    ->options([
                        'is_president' => 'Presidente di almeno un\'associazione',
                        'is_member' => 'Membro di almeno un\'associazione'
                    ])
                    ->query(function (Builder $query, array $data) {
                        foreach ($data['values'] as $value) {
                            switch ($value) {
                                case 'is_president':
                                    $query->whereHas('presidencyAssociation');
                                    break;
                                case 'is_member':
                                    $query->whereHas('associations');
                                    break;
                                default:
                                    break;
                            }
                        }

                        return $query;
                    })->multiple()
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    AssociateUsersToAssociationAction::make()
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            TextEntry::make('name')->label('Nome'),
            TextEntry::make('email')->label('E-mail'),
            TextEntry::make('created_at')->label('Creato il')->dateTime(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\AssociationsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
