<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Advice extends Model
{

     protected $fillable = [
        'doctor_id',
        'title',
        'description',
    ];

      public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
