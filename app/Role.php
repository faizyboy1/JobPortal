<?php

namespace App;

use Trebol\Entrust\EntrustRole;
use Illuminate\Database\Eloquent\Builder;

class Role extends EntrustRole
{
    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('company', function (Builder $builder) {
            if (auth()->check() && !auth()->user()->is_superadmin) {
                $builder->where('roles.company_id', user()->company_id);
            }
        });
    }

    public function permissions()
    {
        return $this->hasMany(PermissionRole::class, 'role_id');
    }

    public function permissionsList()
    {
        return $this->hasMany(Permission::class, 'role_id');
    }

    public function roleuser()
    {
        return $this->hasMany(RoleUser::class, 'role_id');
    }
}
