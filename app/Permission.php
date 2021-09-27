<?php namespace App;

use Trebol\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    protected $guarded = ['id'];
}
