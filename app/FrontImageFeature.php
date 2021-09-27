<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class FrontImageFeature extends Model
{
    protected $appends = [
        'image_url'
    ];

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_settings_id');
    }

    public function getImageUrlAttribute()
    {
        if(Str::contains($this->image,'feature')){
            return asset('front/assets/img/'.$this->image);
        }
        return asset_url('front-features/' . $this->image);
    }

}
