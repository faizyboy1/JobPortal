<?php

namespace App\Http\Controllers\SaasFront;

use App\FrontCmsHeader;
use App\Http\Controllers\Controller;
use App\LanguageSetting;
use App\ThemeSetting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class SaasFrontBaseController extends Controller
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

    /**
     * UserBaseController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->adminTheme = ThemeSetting::whereNull('company_id')->first();
        $this->companyName = $this->global->company_name;
        $this->languages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        if (request()->hasCookie('language_code')) {
            $langArray =  explode('|', decrypt(Cookie::get('language_code'), false));
            $this->locale = isset($langArray[1]) ? $langArray[1] : $langArray[0];
            App::setLocale($this->locale);
            // App::setLocale(decrypt(request()->cookie('language_code'), false));
        } else {
            App::setLocale($this->global->locale);
        }
        $this->localeLanguage = LanguageSetting::where('language_code', App::getLocale())->first();
        $this->englishLangId = LanguageSetting::select('id', 'language_code')->where('language_code', 'en')->first()->id;

        $headerDataCount = FrontCmsHeader::select('id', 'language_settings_id')->where('language_settings_id', $this->localeLanguage->id)->count();
        $this->headerData = FrontCmsHeader::where('language_settings_id', $headerDataCount > 0 ? $this->localeLanguage->id : $this->englishLangId)->first();
        $this->firstHeaderData = FrontCmsHeader::first();
    }
}
