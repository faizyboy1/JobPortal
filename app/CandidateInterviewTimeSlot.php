<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\JobApplication;
class CandidateInterviewTimeSlot extends Model
{
    protected $guarded = ['id'];

    public function jobApplication(){
        return $this->hasMany(JobApplication::class);
    }
}
