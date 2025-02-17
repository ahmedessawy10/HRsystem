<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'time_in',
        'time_out',
        'date',
        'user_id',
        'late_minutes',
        'extra_minutes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}