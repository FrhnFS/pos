<?php

namespace App\Filament\Resources\PembelianItemResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use App\Models\pembelianItem;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\Summarizers\Summarizer;

class pembelianItemWidget extends BaseWidget
{
    public $pembelianId;
    
    public function mount($record)
    {
        $this->pembelianId = $record;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                pembelianItem::query()->where('pembelian_id', $this->pembelianId),
            )
            ->columns([
                TextColumn::make('barang.nama')->label('Nama Barang'),
                TextColumn::make('jumlah')->label('Jumlah Barang')->alignCenter(),
                TextColumn::make('harga')->label('Harga Barang')->money('IDR')->alignEnd(),
                
                // Sebelum Pajak
                TextColumn::make('total_sebelum_pajak')
                    ->label('Total Sebelum Pajak')
                    ->getStateUsing(function ($record) {
                        return $record->jumlah * $record->harga;
                    })
                    ->money('IDR')
                    ->alignEnd()
                    ->summarize(
                        Summarizer::make()
                            ->using(function ($query) {
                                return $query->sum(DB::raw('jumlah * harga'));
                            })
                            ->money('IDR')
                            ->label('Total')
                    ),
                
                // Sesudah Pajak
                TextColumn::make('total_setelah_pajak')
                    ->label('Total Setelah Pajak (11%)')
                    ->getStateUsing(function ($record) {
                        return ($record->jumlah * $record->harga) * 1.11;
                    })
                    ->money('IDR')
                    ->alignEnd()
                    ->summarize(
                        Summarizer::make()
                            ->using(function ($query) {
                                return $query->sum(DB::raw('(jumlah * harga) * 1.11'));
                            })
                            ->money('IDR')
                            ->label('Total+Tax')
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                ->form([
                    TextInput::make('jumlah')->required(),
                
            ]),
                Tables\Actions\DeleteAction::make()
            ]);
    }
}