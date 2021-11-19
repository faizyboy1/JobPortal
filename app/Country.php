<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function candidateResume()
    {
        return $this->hasMany(CandidateResume::class);
    }
}
