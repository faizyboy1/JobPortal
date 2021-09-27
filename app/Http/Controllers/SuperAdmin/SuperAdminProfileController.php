<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\UpdateProfile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SmsSetting;
use Illuminate\Support\Facades\Hash;

class SuperAdminProfileController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.myProfile';
        $this->pageIcon = 'ti-user';
        $this->smsSettings = SmsSetting::first();
    }

    public function index(){
        $this->calling_codes = $this->getCallingCodes();
        return view('super-admin.profile.index', $this->data);
    }

    public function update(UpdateProfile $request){

        $user = $this->user;
        $user->name = $request->name;
        $user->email = $request->email;

        if($request->password != ''){
            $user->password = Hash::make($request->password);
        }

        if ($request->has('mobile')) {
            if ($user->mobile !== $request->mobile || $user->calling_code !== $request->calling_code) {
                $user->mobile_verified = 0;
            }

            $user->mobile = $request->mobile;
            $user->calling_code = $request->calling_code;
        }

        if ($request->hasFile('image')) {
            $user->image = Files::upload($request->image,'profile');
        }
        $user->save();

        return Reply::redirect(route('superadmin.profile.index'), __('menu.myProfile').' '.__('messages.updatedSuccessfully'));
    }
}
