<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'address',
        'name',
        'city',
        'latitude',
        'longitude',
        'radius',
        'phone',
        'email',
    ];
}
