<?php

namespace App\Filament\Resources\SesiLatihanResource\Pages;

use App\Filament\Resources\SesiLatihanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSesiLatihan extends EditRecord
{
    protected static string $resource = SesiLatihanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
