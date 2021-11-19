<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    protected $guarded = ['id'];
    public function candidateResume()
    {
        return $this->belongsTo(CandidateResume::class);
    }
}
