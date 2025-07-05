<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Prescription;

class VitalSign extends Model
{
   protected $fillable = [
        'prescription_id',
        'pulse_rate',
        'respiration_rate',
        'bp_higher',
        'bp_lower',
        'temperature',
        'temperature_type',
        'weight',
        'weight_type',
        'height',
        'height_type',
        'hart_rate',
        'oxygen_saturation',
        'blood_oxygen',
        'ofs',
        'fhr',
        'bmi',
        'bsa',
        'bmi_status',
        'lpm_date',
    ];

    /**
     * Relationship: VitalSign belongs to Prescription
     */
    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }


}
