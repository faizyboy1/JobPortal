<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class JobLocation extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && !auth()->user()->is_superadmin) {
                $builder->where('job_locations.company_id', auth()->user()->company_id);
            }
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
}
