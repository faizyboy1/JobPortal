<?php

namespace App;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

// use Observers\ZoomCategoryObserver;

class Category extends Model
{
    
    protected $table = 'zoom_categories';
    protected $fillable = [];

    protected static function boot()
    {
        parent::boot();

        // static::observe(ZoomCategoryObserver::class);

        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('zoom_categories.company_id', user()->company_id);
        });
    }
}
