<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    protected $fillable = [
        'department_id',
        'name',
    ];

    protected $table = "job_positions";
    public function department()
    {
        return   $this->belongsTo(Department::class, 'department_id');
    }
}
