<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'university',
        'degree',
        'specialization',
        'experience',
        'designation',
        'institution',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

