<?php

namespace App\Http\Controllers\Auth;

use App\FrontCmsHeader;
use App\Http\Controllers\Controller;
use App\ThemeSetting;
use App\User;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\GlobalSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, AppBoot;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');

        App::setLocale($this->global->locale);
    }

    public function showLoginForm()
    {
        if (!$this->isLegal()) {
            return redirect('verify-purchase');
        }

        if (auth()->check()) {
            if (auth()->user()->is_superadmin) {
                return redirect(route('superadmin.dashboard.index'));
            } elseif (!auth()->user()->is_superadmin && auth()->user()->company_id == null) {
                return redirect(route('candidate.dashboard'));
            }
            return redirect('admin/dashboard');
        }
        $setting = $this->global;
        $global = $this->global;
        $frontTheme = ThemeSetting::whereNull('company_id')->first();
        $headerData = FrontCmsHeader::first();

        return view('auth.login', [
            'setting' => $setting,
            'frontTheme' => $frontTheme,
            'headerData' => $headerData,
            'global' => $global,
            'adminTheme' => $this->adminTheme
        ]);
    }

    protected function credentials(\Illuminate\Http\Request $request)
    {
        //return $request->only($this->username(), 'password');
        return [
            'email' => $request->{$this->username()},
            'password' => $request->password,
            'status' => 'active'
        ];
    }

    protected function validateLogin(\Illuminate\Http\Request $request)
    {

        $rules = [
            $this->username() => 'required|string',
            'password' => 'required|string'
        ];

        // User type from email/username
        $user = User::where($this->username(), $request->{$this->username()})->first();


        if (module_enabled('Subdomain')) {
            $rules = $this->rulesValidate($user);
        }
        $this->validate($request, $rules);
    }
    protected function redirectTo()
    {
        $user = auth()->user();
        if ($user->is_superadmin) {
            return 'super-admin/dashboard';
        } elseif ($user->roles[0]->name == 'candidate') {
            return 'candidate/dashboard';
        }
        return 'admin/dashboard';
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $this->guard()->logout();

        $request->session()->invalidate();

        if (module_enabled('Subdomain')) {
            if ($user->is_superadmin) {
                return $this->loggedOut($request) ?: redirect(route('front.super-admin-login'));
            }
            return redirect(route('login'));
        }

        return redirect(route('login'));
    }

    private function rulesValidate($user)
    {
        if (Str::contains(url()->previous(), 'super-admin-login')) {
            $rules = [
                $this->username() => [
                    'required',
                    'string',
                    Rule::exists('users', 'email')->where(function ($query) {
                        $query->where('is_superadmin', '1');
                    })
                ],
                'password' => 'required|string',
            ];
        } else {
            $company = getCompanyBySubDomain();

            $rules = [
                $this->username() => [
                    'required',
                    'string',
                    Rule::exists('users', 'email')->where(function ($query) use ($company) {
                        $query->where('company_id', $company->id);
                    })
                ],
                'password' => 'required|string',

            ];
        }
        return $rules;
    }

    private function get_domain()
    {
        $host = $_SERVER['HTTP_HOST'];
        $myhost = strtolower(trim($host));
        $count = substr_count($myhost, '.');
        if ($count === 2) {
            if (strlen(explode('.', $myhost)[1]) > 3) $myhost = explode('.', $myhost, 2)[1];
        } else if ($count > 2) {
            $myhost = get_domain(explode('.', $myhost, 2)[1]);
        }
        return $myhost;
    }
}
