<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Skill extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && !auth()->user()->is_superadmin) {
                $builder->where('skills.company_id', user()->company_id);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(JobCategory::class, 'category_id');
    }

    protected $guarded = ['id'];
}
