<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    protected $fillable = [
        'app_name',
        'app_logo',
        'app_favicon',
        'app_email',
        'app_phone',
        'app_address'
    ];
}