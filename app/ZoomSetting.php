<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Builder;
use App\User;


class ZoomSetting extends Model
{
    protected $table = 'zoom_settings';

    protected $fillable = ['api_key', 'secret_key', 'meeting_app', 'company_id', 'id'];

    protected static function boot()
    {
        parent::boot();

        // static::addGlobalScope('company', function (Builder $builder) {
        //     $builder->where('zoom_settings.company_id', user()->company_id);
        // });
    }
    
    protected static function setZoom()
    {
        $zoomSetting = ZoomSetting::first();

        if ($zoomSetting) {
            Config::set('zoom.api_key', $zoomSetting->api_key);
            Config::set('zoom.api_secret', $zoomSetting->secret_key);
        }
    }
}
