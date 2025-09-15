<?php

namespace App\Filament\Resources\SesiLatihanResource\Pages;

use App\Filament\Resources\SesiLatihanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSesiLatihans extends ListRecords
{
    protected static string $resource = SesiLatihanResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}
