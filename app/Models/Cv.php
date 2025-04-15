<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
        'summary',
        'experience_years',
        'skill_score',
        'education_score',
        'fit_score'
    ];

    protected $casts = [
        'analysis_result' => 'array',
        'experience_years' => 'integer',
        'skill_score' => 'integer',
        'soft_skills' => 'string',
        'education_score' => 'integer',
        'relevant_experience' => 'string',
        'fit_score' => 'integer'
    ];
}
