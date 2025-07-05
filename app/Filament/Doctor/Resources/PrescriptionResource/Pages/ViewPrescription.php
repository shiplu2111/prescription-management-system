<?php

namespace App\Filament\Doctor\Resources\PrescriptionResource\Pages;

use App\Filament\Doctor\Resources\PrescriptionResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Prescription;

class ViewPrescription extends ViewRecord
{
    protected static string $resource = PrescriptionResource::class;

    protected static string $view = 'filament.doctor.resources.prescription-resource.pages.view-prescription';
    protected function resolveRecord($key): \Illuminate\Database\Eloquent\Model
    {
        return Prescription::with(['doctor', 'patient', 'vitalSign'])->findOrFail($key);
    }
    public function getHeading(): string
    {
        return '';
    }

    // 🚫 Remove breadcrumbs
    // public function getBreadcrumbs(): array
    // {
    //     return [];
    // }
}
