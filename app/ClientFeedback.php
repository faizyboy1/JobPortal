<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientFeedback extends Model
{
    protected $table ='client_feedbacks';

    public function language()
    {
        return $this->belongsTo(LanguageSetting::class, 'language_settings_id');
    }
}
