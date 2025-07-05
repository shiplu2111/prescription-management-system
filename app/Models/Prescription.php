<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Medicine;
use App\Models\MedicinePrescription;
use App\Models\VitalSign;
use App\Models\Patient;

class Prescription extends Model
{
    protected $fillable = ['patient_id', 'doctor_id', 'prescription_medicines', 'date', 'next_visit_date', 'next_visit_fee', 'complaint',
    'investigavion', 'advice','patient_name','patient_age','patient_gender','patient_mobile','patient_address'];

    protected $casts = [
        'complaint' => 'array',
        'investigavion' => 'array',
        'prescription_medicines' => 'array',
        'advice' => 'array',
    ];

   public function patient()
{
    return $this->belongsTo(Patient::class);
}

    public function doctor()
{
    return $this->belongsTo(User::class, 'doctor_id');
}

    public function vitalSign()
    {
        return $this->hasOne(VitalSign::class);
    }

}
