<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    protected $guarded = ['id'];
    
    protected $casts = [
        'social_links' => 'array'
    ];

    // public function getImageUrlAttribute()
    // {
    //     return ($this->image) ? asset_url('front/' . $this->image) : asset('saas/img/home/home-crm.png');
    // }

    // public function getLightColorAttribute()
    // {
    //     if(strlen($this->primary_color)===7){
    //         return $this->primary_color.'26';
    //     }
    //     return $this->primary_color;
    // }
}
