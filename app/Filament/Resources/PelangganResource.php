<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PelangganResource\Pages;
use App\Filament\Resources\PelangganResource\RelationManagers;
use App\Models\Pelanggan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class PelangganResource extends Resource
{
    protected static ?string $model = Pelanggan::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $label = 'Data Pelanggan';
    protected static ?string $navigationGroup = 'penjualan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')
                ->required()
                ->minLength(3),
                TextInput::make('no_hp')
                ->unique(ignoreRecord: true)
                ->label('No Handphone'),
                TextInput::make('alamat'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama'),
                TextColumn::make('no_hp'),
                TextColumn::make('alamat'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPelanggans::route('/'),
            'create' => Pages\CreatePelanggan::route('/create'),
            'edit' => Pages\EditPelanggan::route('/{record}/edit'),
        ];
    }
}
