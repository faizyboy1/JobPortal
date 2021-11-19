<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LanguageResume extends Model
{
    protected $guarded = ['id'];
    public function candidateResume()
    {
        return $this->belongsTo(CandidateResume::class);
    }
}
