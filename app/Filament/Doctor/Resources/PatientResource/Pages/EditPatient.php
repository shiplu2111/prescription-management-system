<?php

namespace App\Filament\Doctor\Resources\PatientResource\Pages;

use App\Filament\Doctor\Resources\PatientResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditPatient extends EditRecord
{
    protected static string $resource = PatientResource::class;
    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make()
            // ->successNotification(
            //          Notification::make()
            //         ->title('Deleted 😒😒')
            //         ->body('The Patient has been successfully Deleted.')
            //         ->success()
            //     ),
        ];
    }
         protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotification(): ?Notification
    {
        return  Notification::make()
            ->title(' Updated 💃💃')
            ->body('The Patient has been successfully Updated.')
            ->success()
            ->send();
    }
}
