<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class InterviewScheduleEmployee extends Model
{
    use Notifiable;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('interview_schedule_employees.company_id', user()->company_id);
        });
    }


    public function schedule(){
        return $this->belongsTo(InterviewSchedule::class, 'interview_schedule_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
