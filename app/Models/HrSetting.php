<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrSetting extends Model
{
    protected $fillable = [
        'discount',
        'overtime',
        'holidays',
        'start_time',
        'end_time',
    ];

    protected $cast = [
        'holidays' => 'array',
    ];
}
