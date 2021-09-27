<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Files;
use App\Helper\Reply;
use App\Http\Requests\UpdateProfile;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.myProfile';
        $this->pageIcon = 'ti-user';
    }

    public function index(){
        $this->calling_codes = $this->getCallingCodes();
        return view('admin.profile.index', $this->data);
    }

    public function update(UpdateProfile $request){

        $user = User::find($this->user->id);
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

        return Reply::redirect(route('admin.profile.index'), __('menu.myProfile').' '.__('messages.updatedSuccessfully'));
    }
}
