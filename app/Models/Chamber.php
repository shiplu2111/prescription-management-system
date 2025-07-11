<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chamber extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'opening_time',
        'closing_time',
        'doctor_id',
        'status',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
