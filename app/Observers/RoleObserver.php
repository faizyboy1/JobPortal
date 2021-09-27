<?php

namespace App\Observers;

use App\Role;

class RoleObserver
{
    public function saving(Role $role)
    {
        if (company()) {
            $role->company_id = company()->id;
        }
    }
}
