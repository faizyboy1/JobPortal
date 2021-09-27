<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class JobSkill extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && !auth()->user()->is_superadmin) {
                $builder->where('job_skills.company_id', user()->company_id);
            }
        });
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }
}
