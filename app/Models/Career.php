<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'title',
        'department_id',
        'description',
        "status",
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function applications()
    {
        return $this->hasMany(CareerApplication::class);
    }
}
