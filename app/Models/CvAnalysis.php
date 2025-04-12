<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class CV extends Model
{
    protected $table = 'cvs';

    protected $fillable = [
        'name',
        'path',
        'summary',
        'experience_years',
        'skill_score',
        'soft_skills',
        'education_score',
        'relevant_experience',
        'fit_score'
    ];

    public function calculateFitScore(): void
    {
        $this->fit_score = round(
            ($this->skill_score + 
            $this->soft_skills + 
            $this->education_score + 
            $this->relevant_experience) / 4
        );
        $this->save();
    }
}

class CvAnalysis extends Model
{
    protected $fillable = [
        'user_id',
        'file_name',
        'file_path',
        'status',
        'analysis_result',
        'summary',
        'experience_years',
        'skill_score',
        'soft_skills',
        'education_score',
        'relevant_experience',
        'fit_score'
    ];

    protected $casts = [
        'analysis_result' => 'array',
        'experience_years' => 'integer',
        'skill_score' => 'integer',
        'soft_skills' => 'integer',
        'education_score' => 'integer',
        'relevant_experience' => 'integer',
        'fit_score' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function calculateFitScore(): void
    {
        $this->fit_score = round(
            ($this->skill_score + 
            $this->soft_skills + 
            $this->education_score + 
            $this->relevant_experience) / 4
        );
        $this->save();
    }

    public function getFileContents(): ?string
    {
        if (!$this->file_path) {
            return null;
        }
        
        return Storage::disk('public')->exists($this->file_path) 
            ? Storage::disk('public')->get($this->file_path) 
            : null;
    }

    public function getFileUrl(): ?string
    {
        return $this->file_path 
            ? Storage::disk('public')->url($this->file_path) 
            : null;
    }
}