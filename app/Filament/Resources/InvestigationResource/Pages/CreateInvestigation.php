<?php

namespace App\Filament\Resources\InvestigationResource\Pages;

use App\Filament\Resources\InvestigationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateInvestigation extends CreateRecord
{
    protected static string $resource = InvestigationResource::class;
       protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title(' Created 💃💃')
            ->body('The Investigation has been successfully created.')
            ->success()
            ->send();
    }
    protected function getCreatedNotification(): ?Notification
    {
        return null; // disables the default "Created" notification
    }
}
