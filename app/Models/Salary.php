<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $fillable = [
        "user_id",
        "month",
        "year",
        "delay_hours",
        "extra_hours",
        "delay_cost",
        "extra_cost",
        "salary",
        "absent",
        "net_salary",
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
