<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeoDetail extends Model
{
    protected $guarded = ['id'];

    public function footer_menu()
    {
        $this->belongsTo(FooterMenu::class);
    }
}
