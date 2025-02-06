<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use App\Models\Pembelian;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PembelianResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PembelianResource\RelationManagers;
use App\Models\supplier;
use Filament\Forms\Components\DatePicker;

class PembelianResource extends Resource
{
    protected static ?string $model = Pembelian::class;

    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $label = 'data pembelian';
    protected static ?string $navigationGroup = 'Pembelian Barang';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('tanggal')
                ->label('Tanggal Pembelian')
                ->required('')
                ->default(now())
                ->columnSpanFull(),
                Select::make('supplier_id')
                ->options(
                    supplier::pluck('nama_perusahaan','id')
                )
                ->searchable()
                ->label('pilih suplier')
                ->createOptionForm(
                    \app\Filament\Resources\SupplierResource::getForm()
                )
                ->createOptionUsing(function (array $data): int {
                    return supplier::create($data)->id;
                })
                ->reactive()
                ->afterStateUpdated(function($state, Set $set){
                    $supplier = supplier::find($state);
                    $set('email', $supplier->email ?? null);
                })
                ,

                TextInput::make('email')->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('supplier.nama_perusahaan')->label('Nama Perusahaan'),
                TextColumn::make('supplier.nama')->label('Nama Penghubung'),
                TextColumn::make('tanggal')->dateTime('d F Y')
                ->label('Tanggal Pembelian'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPembelians::route('/'),
            'create' => Pages\CreatePembelian::route('/create'),
            'edit' => Pages\EditPembelian::route('/{record}/edit'),
        ];
    }
}
