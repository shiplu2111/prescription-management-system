<?php

namespace App\Filament\Doctor\Resources\PrescriptionResource\Pages;

use App\Filament\Doctor\Resources\PrescriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreatePrescription extends CreateRecord
{
    protected static string $resource = PrescriptionResource::class;
    protected static bool $canCreateAnother = false;
   protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('view', ['record' => $this->record]);
}
    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Prescription Created')
            ->body('The Prescription has been successfully created.')
            ->success()
            ->send();
    }
    protected function getCreatedNotification(): ?Notification
    {
        return null; // disables the default "Created" notification
    }
}
