<?php

namespace App\Filament\Resources\ChiefComplaintResource\Pages;

use App\Filament\Resources\ChiefComplaintResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateChiefComplaint extends CreateRecord
{
    protected static string $resource = ChiefComplaintResource::class;
       protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function afterCreate(): void
    {
        Notification::make()
            ->title(' Created 💃💃')
            ->body('The CC has been successfully created.')
            ->success()
            ->send();
    }
    protected function getCreatedNotification(): ?Notification
    {
        return null; // disables the default "Created" notification
    }
}
