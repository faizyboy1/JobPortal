<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OnboardFiles extends Model
{

    protected $table = 'on_board_files';
    protected $fillable = ['on_board_detail_id', 'name', 'file', 'hash_name'];
    protected $appends = ['ext'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('on_board_files.company_id', user()->company_id);
            }
        });
    }

    public function onBoard()
    {
        return $this->belongsTo(Onboard::class);
    }

    public function getExtAttribute()
    {
        $fileName = explode('.', $this->file);
        return $fileName[(sizeof($fileName)-1)];
    }
}
