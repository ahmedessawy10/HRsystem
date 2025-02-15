<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HRSetting extends Model
{
    use HasFactory;
    protected $table = 'hr_settings'; // تأكد أن الاسم صحيح
    protected $fillable = ['overtime', 'discount', 'day_off_1', 'day_off_2','alternative_day_off',];
}
