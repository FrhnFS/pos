<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1; // Urutan tampilan widget

    protected function getCards(): array
    {
        return [
            Card::make('Total pelanggan', \App\Models\pelanggan::count()),
            Card::make('Total Supplier', \App\Models\supplier::count()),
            Card::make('Total Pembelian', \App\Models\pembelianItem::count()),
        ];
    }
}