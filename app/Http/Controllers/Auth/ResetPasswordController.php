<?php

namespace App\Http\Controllers\Auth;

use App\FrontCmsHeader;
use App\GlobalSetting;
use App\Http\Controllers\Controller;
use App\ThemeSetting;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        $setting = GlobalSetting::first();
        $frontTheme = ThemeSetting::whereNull('company_id')->first();
        $headerData = FrontCmsHeader::first();
        $setting = $this->global;
        $global = $this->global;
        return view('auth.passwords.reset')->with(
            [
                'token' => $token,
                'setting' => $setting,
                'frontTheme' => $frontTheme,
                'headerData' => $headerData,
                'global'=>$global,
            ]
        );
    }

    protected function redirectTo()
    {
        $user = auth()->user();
        if ($user->is_superadmin) {
            return 'super-admin/dashboard';
        }

        if ($user->hasRole('admin')) {
            return 'admin/dashboard';
        } elseif ($user->hasRole('employee')) {
            return 'member/dashboard';
        }

    }
}
