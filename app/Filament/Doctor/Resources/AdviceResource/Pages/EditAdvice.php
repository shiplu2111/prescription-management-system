<?php

namespace App\Filament\Doctor\Resources\AdviceResource\Pages;

use App\Filament\Doctor\Resources\AdviceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAdvice extends EditRecord
{
    protected static string $resource = AdviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
