<?php

namespace App\Filament\Doctor\Resources\AdviceResource\Pages;

use App\Filament\Doctor\Resources\AdviceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdvice extends ListRecords
{
    protected static string $resource = AdviceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
