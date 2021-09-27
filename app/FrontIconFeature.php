<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontIconFeature extends Model
{
    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_settings_id');
    }
}
