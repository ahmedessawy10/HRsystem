<?php

namespace App\Models;

use App\Models\JobPosition;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function jobs(){
        return $this->hasMany(JobPosition::class);
    }
}
