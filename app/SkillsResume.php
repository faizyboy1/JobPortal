<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillsResume extends Model
{
    protected $guarded = ['id'];
    public function candidateResume()
    {
        return $this->belongsTo(CandidateResume::class);
    }
}
