<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'favicon',
        'time_zone',
        'currancy',
        'language',
        'date_format',
        'time_format',
    ];
}
