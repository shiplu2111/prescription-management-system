<?php

namespace App\Filament\Doctor\Resources\ChamberResource\Pages;

use App\Filament\Doctor\Resources\ChamberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChambers extends ListRecords
{
    protected static string $resource = ChamberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
