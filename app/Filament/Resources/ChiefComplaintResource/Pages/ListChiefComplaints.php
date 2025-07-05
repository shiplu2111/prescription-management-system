<?php

namespace App\Filament\Resources\ChiefComplaintResource\Pages;

use App\Filament\Resources\ChiefComplaintResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChiefComplaints extends ListRecords
{
    protected static string $resource = ChiefComplaintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
