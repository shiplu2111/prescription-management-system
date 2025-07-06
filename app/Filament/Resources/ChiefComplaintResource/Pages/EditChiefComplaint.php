<?php

namespace App\Filament\Resources\ChiefComplaintResource\Pages;

use App\Filament\Resources\ChiefComplaintResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditChiefComplaint extends EditRecord
{
    protected static string $resource = ChiefComplaintResource::class;

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
