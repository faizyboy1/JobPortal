<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CandidateResume extends Model
{
    protected $guarded = ['id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function profileImage()
    {
        $imagePath = ($this->profile_picture) ? $this->profile_picture : 'https://images.unsplash.com/photo-1586962358070-16a0f05b8e67?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1000&q=80';
        return '/storage/' . $imagePath;
    }
    public function education()
    {
        return $this->hasMany(Education::class);
    }
    public function certification()
    {
        return $this->hasMany(Certification::class);
    }
    public function awards()
    {
        return $this->hasMany(AwardResume::class);
    }
    public function language()
    {
        return $this->hasMany(LanguageResume::class);
    }
    public function skills()
    {
        return $this->hasMany(SkillsResume::class);
    }
    public function workExperience()
    {
        return  $this->hasMany(WorkExperience::class);
    }
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
