<?php

namespace App\Filament\Resources\InvestigavionResource\Pages;

use App\Filament\Resources\InvestigavionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestigavions extends ListRecords
{
    protected static string $resource = InvestigavionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
