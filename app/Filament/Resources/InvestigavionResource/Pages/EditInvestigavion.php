<?php

namespace App\Filament\Resources\InvestigavionResource\Pages;

use App\Filament\Resources\InvestigavionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditInvestigavion extends EditRecord
{
    protected static string $resource = InvestigavionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
