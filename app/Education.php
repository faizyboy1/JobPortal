<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $guarded = ['id'];
    public function candidateResume()
    {
        return $this->belongsTo(CandidateResume::class);
    }
}
