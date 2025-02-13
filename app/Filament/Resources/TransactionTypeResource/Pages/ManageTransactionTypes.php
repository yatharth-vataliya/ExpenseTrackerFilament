<?php

namespace App\Filament\Resources\TransactionTypeResource\Pages;

use App\Filament\Resources\TransactionTypeResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ManageRecords;

class ManageTransactionTypes extends ManageRecords
{
    protected static string $resource = TransactionTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Create New Transaction Type')
                ->mutateFormDataUsing(function (array $data) {
                    return array_merge($data, ['user_id' => auth()->id()]);
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Transaction Type')
                        ->body('New transaction type created')
                ),
        ];
    }
}
