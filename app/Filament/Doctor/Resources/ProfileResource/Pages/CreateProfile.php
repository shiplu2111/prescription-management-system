<?php

namespace App\Filament\Doctor\Resources\ProfileResource\Pages;

use App\Filament\Doctor\Resources\ProfileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProfile extends CreateRecord
{
    protected static string $resource = ProfileResource::class;
}
