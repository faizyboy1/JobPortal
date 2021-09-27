<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TodoItem extends Model
{
    protected static function boot()
    {
        parent::boot();

        if(auth()->check()){
            static::addGlobalScope('company', function (Builder $builder) {
                $builder->where('todo_items.company_id', auth()->user()->company_id);
            });
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
