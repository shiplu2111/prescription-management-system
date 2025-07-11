<?php

namespace App\Filament\Doctor\Resources\ChamberResource\Pages;

use App\Filament\Doctor\Resources\ChamberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChamber extends EditRecord
{
    protected static string $resource = ChamberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
