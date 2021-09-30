<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Auth;

class CandidateBaseController extends Controller
{
    /**
     * @var array
     */
    public $data = [];

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $this->rtl = $this->adminTheme->rtl;
            $this->pageIcon = 'icon-speedometer';
            $this->pageTitle = 'menu.dashboard';
            $this->getPermissions = User::with('roles.permissions.permission')->find($this->user->id);
            $userPermissions = array();
            foreach ($this->getPermissions->roles[0]->permissions as $key => $value) {
                $userPermissions[] = $value->permission->name;
            }
            $this->userPermissions = $userPermissions;
            return $next($request);
        });
        // $this->user = Auth::user();
        // $this->rtl = $this->adminTheme->rtl;
        // $this->pageIcon = 'icon-speedometer';
        // $this->pageTitle = 'menu.dashboard';
        // $this->getPermissions = User::with('roles.permissions.permission')->find($this->user->id);
        // $userPermissions = array();
        // foreach ($this->getPermissions->roles[0]->permissions as $key => $value) {
        //     $userPermissions[] = $value->permission->name;
        // }
        // $this->userPermissions = $userPermissions;
    }
}
