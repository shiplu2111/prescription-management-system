<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investigation extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];
}
