<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class JobCategory extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && !auth()->user()->is_superadmin) {
                $builder->where('job_categories.company_id', auth()->user()->company_id);
            }
        });
    }

    public function skills()
    {
        return $this->hasMany(Skill::class, 'category_id');
    }
}
