<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Filament\Resources\TransactionResource\Widgets\ExpenseOverview;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Log;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('transaction_type_id')
                    ->label('Select transaction type')
                    ->required()
                    ->relationship('transactionType', 'transaction_type_name')
                    ->searchable()
                    ->preload()
                    ->createOptionModalHeading('Create new transaction type')
                    ->manageOptionForm(TransactionTypeResource::getFormFields())
                    ->manageOptionActions(
                        fn(Action $action) => $action->mutateFormDataUsing(
                            fn(array $data) => array_merge($data, ['user_id' => auth()->id()])
                        )
                    ),
                Forms\Components\Textarea::make('description')
                    ->label('Transaction description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('item_unit')
                    ->label('Item unit')
                    ->maxLength(255),
                Forms\Components\TextInput::make('item_count')
                    ->label('Item count')
                    ->required()
                    ->numeric()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                        $itemCount = (int) $state;
                        $set('total', $itemCount * (int) $get('item_price'));
                    }),
                Forms\Components\TextInput::make('item_price')
                    ->label('Item price')
                    ->required()
                    ->numeric()
                    ->live()
                    ->afterStateUpdated(function (Set $set, Get $get, ?string $state) {
                        $itemPrice = (int) $state;
                        $set('total', $itemPrice * (int) $get('item_count'));
                    }),
                Forms\Components\TextInput::make('total')
                    ->numeric()
                    ->disabled(),
                Forms\Components\DatePicker::make('transaction_date')
                    ->required()
                    ->default(now())
                    ->date(),
            ])
            ->model(Transaction::class);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transactionType.id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('item_unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('item_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('item_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('transaction_date')
                    ->date()
                    ->sortable(),
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
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            ExpenseOverview::class,
        ];
    }
}
