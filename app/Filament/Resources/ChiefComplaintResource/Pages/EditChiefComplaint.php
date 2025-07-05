<?php

namespace App\Filament\Resources\ChiefComplaintResource\Pages;

use App\Filament\Resources\ChiefComplaintResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChiefComplaint extends EditRecord
{
    protected static string $resource = ChiefComplaintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
