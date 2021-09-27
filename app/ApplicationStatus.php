<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ApplicationStatus extends Model
{
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()  && !auth()->user()->is_superadmin ) {
               
                $builder->where('application_status.company_id', user()->company_id);
            }
        });
    }

    protected $table = 'application_status';

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'status_id')->orderBy('column_priority');
    }

    public function scopeCompany($query)
    {
        return $query->where('company_id', auth()->user()->company_id);
    }

    public function scopeStatus($query, $type)
    {
        return $query->where('status', $type)->first();
    }
}
