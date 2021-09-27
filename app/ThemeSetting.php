<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ThemeSetting extends Model
{
    protected static function boot()
    {
        parent::boot();

        if(auth()->check()){
            static::addGlobalScope('company', function (Builder $builder) {
                $builder->where('theme_settings.company_id', auth()->user()->company_id);
            });
    
        }
    }

    public function getBackgroundImageUrlAttribute(){
        if(is_null($this->home_background_image)){
            return asset('front/assets/img/header-bg.jpg');
        }
        return asset_url('background/'.$this->home_background_image);
    }
}
