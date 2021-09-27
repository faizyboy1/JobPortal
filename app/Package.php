<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function scopeActive($query) {
        return $query->where('status', 1);
    }
}
