<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ExpenseOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Expense', Transaction::sum('total')),
            //Stat::make('Total Expense', Transaction::whereDate()->count()),
        ];
    }
}
