<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterMenu extends Model
{
    protected $table = 'footer_menu';

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_settings_id');
    }

    public function seo_details()
    {
        return $this->hasOne(SeoDetail::class);
    }
}
