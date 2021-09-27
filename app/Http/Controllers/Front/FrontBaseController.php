<?php

namespace App\Http\Controllers\Front;

use App\LanguageSetting;
use App\ThemeSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use App\Company;

class FrontBaseController extends Controller
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
        return isset($this->data[ $name ]);
    }

    /**
     * UserBaseController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // Inject currently logged in user object into every view of user dashboard

        $this->frontTheme = ThemeSetting::first();
        $this->languageSettings = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        if (request()->hasCookie('language_code')) {
            App::setLocale(decrypt(request()->cookie('language_code'), false));
        }
        else {
            App::setLocale($this->global->locale);
        }
    }
}
