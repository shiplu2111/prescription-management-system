<?php

namespace App\Filament\Doctor\Resources\PrescriptionResource\Pages;

use App\Filament\Doctor\Resources\PrescriptionResource;
use Filament\Resources\Pages\ViewRecord;
use App\Models\Prescription;
use App\Models\Chamber;
use App\Models\Advice;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Model;

class ViewPrescription extends ViewRecord
{
    protected static string $resource = PrescriptionResource::class;

    protected static string $view = 'filament.doctor.resources.prescription-resource.pages.view-prescription';
    protected function resolveRecord($key): \Illuminate\Database\Eloquent\Model
    {
        return Prescription::with(['doctor', 'patient', 'vitalSign','chamber'])->findOrFail($key);
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
     public function getViewData(): array
    {
        return [
            'chambers' => Chamber::where('doctor_id', auth()->id())
                ->get(),
                'advices' => Advice::where('doctor_id', auth()->id())
                ->get(),
                'profile' => Profile::where('user_id', auth()->id())
                ->first(),
        ];
    }
}
