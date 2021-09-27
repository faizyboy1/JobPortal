<?php
use App\Company;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

if (!function_exists('superAdmin')) {
    function superAdmin()
    {
        return auth()->user();
    }
}
if (!function_exists('company')) {
    function company()
    {
        if(auth()->user()) {
            $company = Company::find(auth()->user()->company_id);
            return $company;
        }

        // return false;
    }
}

if (!function_exists('user')) {
    function user()
    {
        if(auth()->check()) {
            return auth()->user();
        }
        // return null;
    }
}

if (!function_exists('asset_url')) {

    // @codingStandardsIgnoreLine
    function asset_url($path)
    {
        $path = 'user-uploads/' . $path;
        $storageUrl = $path;

        if (!Str::startsWith($storageUrl, 'http')) {
            return url($storageUrl);
        }

        return $storageUrl;

    }

}
if (!function_exists('check_migrate_status')) {

    function check_migrate_status()
    {
        if (!session()->has('check_migrate_status')) {

            $status = Artisan::call('migrate:check');

            if ($status && !request()->ajax()) {
                Artisan::call('migrate', array('--force' => true)); //migrate database
                Artisan::call('optimize:clear');
            }
            session(['check_migrate_status' => true]);
        }

        return session('check_migrate_status');
    }
}

if (!function_exists('module_enabled')) {
    function module_enabled($moduleName)
    {
        return \Nwidart\Modules\Facades\Module::collections()->has($moduleName);
    }
}

if (!function_exists('getDomainSpecificUrl')) {
    function getDomainSpecificUrl($url, $company = false)
    {
        if (module_enabled('Subdomain')) {
            // If company specific

            if ($company) {
                $url = str_replace(request()->getHost(), $company->sub_domain, $url);
                $url = str_replace('www.', '', $url);
                // Replace https to http for sub-domain to
                return $url = str_replace('https', 'http', $url);
            }

            // If there is no company and url has login means
            // New superadmin is created
            return $url = str_replace('login', 'super-admin-login', $url);
        }

        return $url;
    }
}

if (!function_exists('get_domain')) {

    function get_domain($host = false)
    {
        if (!$host) {
            $host = $_SERVER['SERVER_NAME'];
        }
        $shortDomain = config('app.short_domain_name');
        $dotCount = ($shortDomain === true) ? 2 : 3;

        $myhost = strtolower(trim($host));
        $count = substr_count($myhost, '.');
        if ($count === 2) {
            if (strlen(explode('.', $myhost)[1]) > $dotCount) $myhost = explode('.', $myhost, 2)[1];
        } else if ($count > 2) {
            $myhost = get_domain(explode('.', $myhost, 2)[1]);
        }
        return $myhost;
    }
}

if (!function_exists('recruit_plugins')) {

    function recruit_plugins()
    {

        if (!session()->has('recruit_plugins')) {
            $plugins = \Nwidart\Modules\Facades\Module::allEnabled();
            // dd(array_keys($plugins));

            // foreach ($plugins as $plugin) {
            //     Artisan::call('module:migrate', array($plugin, '--force' => true));
            // }

            session(['recruit_plugins' => array_keys($plugins)]);
        }
        return session('recruit_plugins');
    }
}

function jobOpenings($slug=null, $companyID = null){
    if(module_enabled('Subdomain')){
        if($slug){
            $subDomian = Company::where('career_page_link', $slug)->first();
            return siteURL().$subDomian->sub_domain;
        }
        return route('jobs.jobOpenings');
    }
    return route('jobs.jobOpenings',$slug);
}
function frontJobOpenings($slug){
    if(module_enabled('Subdomain')){
        return siteURL().$slug;
    }
    return route('jobs.jobOpenings',$slug);
}

function siteURL()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    //$domainName = $_SERVER['HTTP_HOST'].'/';
    return $protocol;
}

if (!function_exists('isRunningInConsoleOrSeeding')) {

    /**
     * Check if app is seeding data
     * @return boolean
     */
    function isRunningInConsoleOrSeeding()
    {
        // We set config(['app.seeding' => true]) at the beginning of each seeder. And check here
        return app()->runningInConsole() || isSeedingData();
    }

}

if (!function_exists('isSeedingData')) {

    /**
     * Check if app is seeding data
     * @return boolean
     */
    function isSeedingData()
    {
        // We set config(['app.seeding' => true]) at the beginning of each seeder. And check here
        return config('app.seeding');
    }

}
