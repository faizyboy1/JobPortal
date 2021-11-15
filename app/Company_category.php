<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\User;
class Company_category extends Model
{
    Protected $guarded = [];

    public function company(){
        return $this->hasMany(Company::class);
    }
    public function user(){
        return $this->hasMany(User::class);
    }
}
