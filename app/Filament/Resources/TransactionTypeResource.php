<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionTypeResource\Pages;
use App\Filament\Resources\TransactionTypeResource\RelationManagers;
use App\Models\TransactionType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionTypeResource extends Resource
{
    protected static ?string $model = TransactionType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getFormFields()
    {
        return [
            Forms\Components\TextInput::make('transaction_type_name')
                ->required()
                ->unique(
                    table: TransactionType::class,
                    ignoreRecord: true,
                )
                ->maxLength(255),
            Forms\Components\Textarea::make('description')
                ->columnSpanFull(),
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFormFields());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('transaction_type_name')
                    ->label('Tranction Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Description of Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            /*->headerActions([*/
            /*    CreateAction::make()*/
            /*        ->label('Create new transaction type')*/
            /*        ->mutateFormDataUsing(function (array $data) {*/
            /*            return array_merge($data, ['user_id' => auth()->id()]);*/
            /*        }),*/
            /*])*/
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTransactionTypes::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
