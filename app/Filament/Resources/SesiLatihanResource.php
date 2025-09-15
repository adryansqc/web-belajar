<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SesiLatihanResource\Pages;
use App\Filament\Resources\SesiLatihanResource\RelationManagers;
use App\Models\SesiLatihan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SesiLatihanResource extends Resource
{
    protected static ?string $model = SesiLatihan::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Pembelajaran';

    protected static ?string $navigationLabel = 'Nilai';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_siswa')
                    ->label('Nama Siswa')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kelas')
                    ->label('Kelas')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('latihan.nama')
                    ->label('Nama Latihan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_benar')
                    ->label('Jawaban Benar')
                    ->sortable(),
                TextColumn::make('total_soal')
                    ->label('Total Soal')
                    ->sortable(),
                TextColumn::make('total_poin')
                    ->label('Total Poin')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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
            'index' => Pages\ListSesiLatihans::route('/'),
            'create' => Pages\CreateSesiLatihan::route('/create'),
            'edit' => Pages\EditSesiLatihan::route('/{record}/edit'),
        ];
    }
}
