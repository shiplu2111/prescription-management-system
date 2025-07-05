<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Prescription;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function prescriptions()
{
    return $this->belongsToMany(Prescription::class, 'medicine_prescription')
                ->withPivot('dose', 'use_mode', 'use_time', 'duration')
                ->withTimestamps();
}
}
