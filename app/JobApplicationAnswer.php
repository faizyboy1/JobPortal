<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class JobApplicationAnswer extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('job_application_answers.company_id', user()->company_id);
            }
        });
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function jobApplication()
    {
        return $this->belongsTo(JobApplication::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
