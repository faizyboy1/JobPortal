<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FrontCmsHeader extends Model
{
    protected $fillable = [
        'language_settings_id',
        'title',
        'description',
        'header_background_color',
        'show_login_in_menu',
        'show_register_in_menu',
        'show_login_in_header',
        'show_register_in_header',
        'custom_css',
        'call_to_action_title',
        'call_to_action_button',
        'contact_text',
        'logo',
        'header_image',
        'header_backround_image',
        'meta_details'
    ];

    protected $appends = [
        'logo_url',
        'header_image_url',
        'header_backround_image_url',
        'login_background_image_url',
        'register_background_image_url'
    ];

    protected $casts = [
        'meta_details' => 'array'
    ];

    public function getLogoUrlAttribute()
    {
        if (is_null($this->logo)) {
            return asset('front-logo.png');
        }
        return asset_url('front-logo/' . $this->logo);
    }

    public function getHeaderImageUrlAttribute()
    {
        if (is_null($this->header_image)) {
            return asset('saas-front/img/header_image.png');
        }
        return asset_url('header-image/' . $this->header_image);
    }

    public function getHeaderBackroundImageUrlAttribute()
    {
        if (is_null($this->header_image)) {
            return asset('saas-front/img/header_image.png');
        }

        return asset_url('header-background-image/' . $this->header_backround_image);
    }
    public function getLoginBackgroundImageUrlAttribute()
    {
        if (is_null($this->login_background)) {
            return asset('assets/images/background/auth.jpg');
        }
        return asset_url('login-background-image/' . $this->login_background);
    }

    public function getRegisterBackgroundImageUrlAttribute()
    {
        if (is_null($this->register_background)) {
            return asset('saas-front/img/register-bg.jpg');
        }

        return asset_url('register-background-image/' . $this->register_background);
    }
}
