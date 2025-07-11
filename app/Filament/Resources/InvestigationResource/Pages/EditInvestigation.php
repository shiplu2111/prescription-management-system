<?php

namespace App\Filament\Resources\InvestigationResource\Pages;

use App\Filament\Resources\InvestigationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditInvestigation extends EditRecord
{
    protected static string $resource = InvestigationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
