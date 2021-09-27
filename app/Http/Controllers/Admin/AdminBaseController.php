<?php

namespace App\Http\Controllers\Admin;

use App\LanguageSetting;
use App\LinkedInSetting;
use App\StickyNote;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use App\ThemeSetting;
use App\Company;
use App\User;
use App\ZoomSetting;
use App\CompanyPackage;
use Illuminate\Support\Facades\DB;
use App\GlobalSetting;

class AdminBaseController extends Controller
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
        // Inject currently logged in user object into every view of user dashboard
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            if ($this->user && $this->user->roles->count() > 0) {
                $this->todoItems = $this->user->todoItems()->groupBy('status', 'position')->get();
            }
            $this->superSettings = GlobalSetting::with('currency')->first();

            $this->getPermissions = User::with('roles.permissions.permission')->find($this->user->id);
            $userPermissions = array();
            foreach ($this->getPermissions->roles[0]->permissions as $key => $value) {
                $userPermissions[] = $value->permission->name;
            }
            $this->userPermissions = $userPermissions;

            $this->global = Company::findOrFail($this->user->company_id);
            $this->adminTheme = ThemeSetting::where('company_id', '=', $this->global->id)->first();
            $this->companyName = $this->global->company_name;
            $this->rtl = $this->adminTheme->rtl;
            $this->languageSettings = LanguageSetting::where('status', 'enabled')->orderBy('language_name')->get();
            $this->activePackage = CompanyPackage::with('package')->where('company_id', $this->user->company_id)
                ->where('status', 'active')
                ->where(function ($query) {
                    $query->where(DB::raw('DATE(end_date)'), '>=', DB::raw('CURDATE()'));
                    $query->orWhereNull('end_date');
                })

                ->first();

            App::setLocale($this->global->locale);
            Carbon::setLocale($this->global->locale);
            setlocale(LC_TIME, $this->global->locale . '_' . strtoupper($this->global->locale));
            $this->linkedinGlobal = LinkedInSetting::first();
            $this->zoom_setting = ZoomSetting::first();

            $this->stickyNotes = StickyNote::where('user_id', $this->user->id)
                ->orderBy('updated_at', 'desc')
                ->get();
            return $next($request);
        });
    }

    public function generateTodoView()
    {
        $pendingTodos = $this->user->todoItems()->status('pending')->orderBy('position', 'DESC')->limit(5)->get();
        $completedTodos = $this->user->todoItems()->status('completed')->orderBy('position', 'DESC')->limit(5)->get();

        $view = view('sections.todo_items_list', compact('pendingTodos', 'completedTodos'))->render();

        return $view;
    }
}
