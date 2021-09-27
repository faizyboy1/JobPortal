<?php

namespace App;

use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Onboard extends Model
{

    protected $table = 'on_board_details';
    protected $dates = ['joining_date', 'accept_last_date'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('on_board_details.company_id', user()->company_id);
            }
        });
    }

    public function files()
    {
        return $this->hasMany(OnboardFiles::class, 'on_board_detail_id');
    }

    public function applications()
    {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function designation(){
        return $this->belongsTo(Designation::class);
    }

    public function reportto(){
        return $this->belongsTo(User::class, 'reports_to_id');
    }
    public function getExt($name){

    }
}
