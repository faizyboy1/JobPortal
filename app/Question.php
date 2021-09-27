<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Question extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && !auth()->user()->is_superadmin) {
                $builder->where('questions.company_id', user()->company_id);
            }
        });
    }

    public function jobs()
    {
        $this->belongsToMany(Job::class, 'job_questions');
    }

    public function answers()
    {
        return $this->hasMany(JobApplicationAnswer::class);
    }

    public function getQuestionAttribute($value)
    {
        return $value.' ?';
    }
}
