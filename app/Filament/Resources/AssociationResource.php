<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AssociationResource\Pages;
use App\Filament\Resources\AssociationResource\RelationManagers;
use App\Models\Association;
use Faker\Provider\Text;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AssociationResource extends Resource
{
    protected static ?string $model = Association::class;
    protected static ?string $navigationLabel = 'Associazioni';
    protected static ?string $modelLabel = 'Associazione';
    protected static ?string $pluralModelLabel = 'Associazioni';
    protected static ?string $navigationGroup = 'Anagrafiche';
    protected static ?string $title = 'Associazioni';
    protected static ?string $slug = 'associations';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label('ID'),
                Tables\Columns\TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('president.name')->label('Presidente')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('city')->label('Città')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('address')->label('Indirizzo')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Creato il')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            RelationManagers\UsersRelationManager::class
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('name')->label('Nome'),
                TextEntry::make('president.name')
                    ->label('Presidente')
                    ->url(fn(Association $record): string => UserResource::getUrl('view', ['record' => $record->president_id])),
                TextEntry::make('city')->label('Città'),
                TextEntry::make('address')->label('Indirizzo'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssociations::route('/'),
            'create' => Pages\CreateAssociation::route('/create'),
            'view' => Pages\ViewAssociation::route('/{record}'),
            'edit' => Pages\EditAssociation::route('/{record}/edit'),
        ];
    }
}
