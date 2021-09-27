<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use Notifiable, SoftDeletes;

    protected $dates = ['dob'];

    protected $casts = [
        'skills' => 'array'
    ];

    protected $appends = ['resume_url', 'photo_url'];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check()) {
                $builder->where('job_applications.company_id', user()->company_id);
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function resumeDocument()
    {
        return $this->morphOne(Document::class, 'documentable')->where('name', 'Resume');
    }

    public function job()
    {
        return $this->belongsTo(Job::class, 'job_id');
    }

    public function onboard()
    {
        return $this->hasOne(Onboard::class, 'job_application_id');
    }

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class, 'status_id');
    }

    public function schedule()
    {
        return $this->hasOne(InterviewSchedule::class)->latest();
    }

    public function notes()
    {
        return $this->hasMany(ApplicantNote::class, 'job_application_id')->orderBy('id', 'desc');
    }

    public function getPhotoUrlAttribute()
    {
        if (is_null($this->photo)) {
            return asset('avatar.png');
        }
        return asset_url('candidate-photos/' . $this->photo);
    }

    public function getResumeUrlAttribute()
    {
        if ($this->documents()->where('name', 'Resume')->first()) {
            return asset_url('documents/' . $this->id . '/' . $this->documents()->where('name', 'Resume')->first()->hashname);
        }
        return false;
    }

    public function routeNotificationForNexmo($notification)
    {
        return $this->phone;
    }

}
