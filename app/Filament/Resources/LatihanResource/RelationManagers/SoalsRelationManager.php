<?php

namespace App\Filament\Resources\LatihanResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use FilamentTiptapEditor\TiptapEditor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SoalsRelationManager extends RelationManager
{
    protected static string $relationship = 'soals';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TiptapEditor::make('pertanyaan')
                    ->required()
                    ->disk('public')
                    ->directory('soal')
                    ->maxContentWidth('full')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('pilihan_a')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pilihan_b')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pilihan_c')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('pilihan_d')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('jawaban_benar')
                    ->options([
                        'A' => 'A',
                        'B' => 'B',
                        'C' => 'C',
                        'D' => 'D',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('waktu_per_soal')
                    ->label('Waktu Per Soal (detik)')
                    ->numeric()
                    ->default(20)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('judul')
            ->columns([
                Tables\Columns\TextColumn::make('pertanyaan')
                    ->limit(50)
                    ->formatStateUsing(fn(string $state): string => strip_tags($state)),
                Tables\Columns\TextColumn::make('jawaban_benar'),
                Tables\Columns\TextColumn::make('waktu_per_soal')
                    ->suffix(' detik'),
            ])
            ->defaultSort('created_at', 'asc')
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
