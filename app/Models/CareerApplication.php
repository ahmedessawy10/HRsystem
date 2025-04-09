<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CareerApplication extends Model
{
    protected $fillable = [
        'career_id',
        'name',
        'email',
        'cv',
        'phone',
        'cover_letter',
        'status',
        'ai_rate',
        'ai_summary',
    ];

    public function career()
    {
        return $this->belongsTo(Career::class);
    }
}
