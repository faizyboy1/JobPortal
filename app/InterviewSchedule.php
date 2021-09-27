<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InterviewSchedule extends Model
{
    protected $dates = ['schedule_date','created_at'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('interview_schedules.company_id', user()->company_id);
        });
    }

    // Relation with job application
    public function jobApplication(){
        return $this->belongsTo(JobApplication::class);
    }
    public function meeting(){
        return $this->belongsTo(ZoomMeeting::class);
    }

    // Relation with user
    public function user(){
        return $this->belongsTo(User::class);
    }

    // Relation with user
    public function comments(){
        return $this->hasMany(ScheduleComments::class);
    }

    // Relation with user
    public function employee(){
        return $this->hasMany(InterviewScheduleEmployee::class);
    }

    public function employees(){
        return $this->belongsToMany(User::class, InterviewScheduleEmployee::class);
    }

    public function employeeData($userId){
        return InterviewScheduleEmployee::where('user_id', $userId)->where('interview_schedule_id', $this->id)->first();
    }
}
