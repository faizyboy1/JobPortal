<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ApplicationSetting extends Model
{
    protected $guarded = ['id'];
    
    protected $casts = [
        'mail_setting' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && !auth()->user()->is_superadmin) {
                $builder->where('application_settings.company_id', company()->id);
            }
        });
    }
}
