<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Patient extends Model
{
    protected $fillable = [
    'name',
    'email',
    'user_id',
    'doctor_id',
    'patient_type',
    'mobile',
    'address',
    'gender',
    'age',
    'date_of_birth',
    'weight',
    'height',
    'image',
    'blood_group',
    'id_type',
    'id_number',
    'guardian_name',
    'guardian_number',
    'guardian_relation',
    'guardian_email',
    'marital_status',
    'spouse_name',
    'spouse_number',
    'spouse_email',
    'contact_person',
    'contact_person_number',
    'contact_person_relation',
    'contact_person_email',
    'status',
];

    protected $casts = [
        'status' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    // public function categories()
    // {
    //     return $this->belongsToMany(Category::class);
    // }
    // public function seoMetadata()
    // {
    //     return $this->hasOne(SeoMetadata::class);
    // }
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($patient) {
            // Delete single image fields
            foreach ([
                'image',
            ] as $field) {
                if ($patient->$field && Storage::disk('public')->exists($patient->$field)) {
                    Storage::disk('public')->delete($patient->$field);
                }
            }


        });
    }

}
