<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ScheduleComments extends Model
{
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('interview_schedule_comments.company_id', user()->company_id);
        });
    }


    protected $dates = ['created_at'];
    protected $table = 'interview_schedule_comments';
    // Relation with job application
    public function jobApplication(){
        return $this->belongsTo(InterviewSchedule::class);
    }

    // Relation with user
    public function user(){
        return $this->belongsTo(User::class);
    }


}
