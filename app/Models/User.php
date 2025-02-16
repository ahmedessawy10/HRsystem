<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'gender',
        'join_date',
        'leave_date',
        'start_time',
        'end_time',
        'last_login',
        'photo',
        'phone',
        'role',
        'birthdate',
        'status',
        'salary',
        'nationality_id',
        'address',
        'category_id',
        'job_position_id',
    ];
    
    
        // use HasFactory;
    
        protected $table = 'users'; // Explicitly define the table name
        // protected $fillable = [
        //     'name', 'fullname', 'email', 'password', 'photo', 'phone', 'role', 
        //     'birthdate', 'gender', 'status', 'salary', 'nationality_id', 'address', 
        //     'join_date', 'leave_date', 'start_time', 'end_time', 'department_id', 
        //     'job_position_id'
        // ];
    // }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
