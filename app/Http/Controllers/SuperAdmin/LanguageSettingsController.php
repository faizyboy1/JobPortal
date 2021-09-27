<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Helper\Reply;
use App\LanguageSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Company;
use App\Http\Requests\Language\StoreLanguage;
use Barryvdh\TranslationManager\Models\Translation;
use Illuminate\Support\Facades\File;

class LanguageSettingsController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'languageSetting';
        $this->pageIcon = 'icon-settings';
        $this->langPath = base_path().'/resources/lang';
    }

    public function index(){
        if (request()->ajax()) {
            $languages = LanguageSetting::all();
            
            return datatables()->of($languages)
            ->addColumn('action', function ($row) {
                $action = '';
                if ($row->language_code !== 'en') {
                    $action .= '<a href="javascript:;" data-row-id="' . $row->id . '" class="btn btn-primary btn-circle edit-language"
                        data-toggle="tooltip" data-original-title="' . __('app.edit') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

                    $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle delete-language-row"
                        data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="' . __('app.delete') . '"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }
                else {
                    $action .= '<span class="text-danger">'.__("modules.languageSettings.defaultLanguageCannotBeModified").'</span>';
                }
                return $action;
            })
            ->editColumn('language_code', function ($row) {
                return strtolower($row->language_code);
            })
            ->editColumn('language_name', function ($row) {
                return ucfirst($row->language_name);
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status == 'enabled' ? 'checked' : '';
                $disabled = ($this->global->locale == $row->language_code) ? 'disabled' : '' ;
                $disabledNote = ($this->global->locale == $row->language_code) ? 'data-toggle="tooltip" data-original-title="'.__('modules.languageSettings.statusDisabledNote').'"' : '' ;
                return '<span '.$disabledNote.' class="switchery-demo">
                            <input '.$disabled.' class="js-switch change-language-setting" type="checkbox" ' . $checked
                . ' value="active" data-lang-id="' . $row->id . '"></span>';
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'status'])
            ->make(true);
        }
        return view('super-admin.language-settings.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super-admin.language-settings.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLanguage $request)
    {
        // check and create lang folder
        $langExists = File::exists($this->langPath.'/'.strtolower($request->language_code));

        if (!$langExists) {
            File::makeDirectory($this->langPath.'/'.strtolower($request->language_code));
        }

        $language = new LanguageSetting();

        $language->language_name = ucfirst(strtolower($request->language_name));
        $language->language_code = strtolower($request->language_code);
        $language->status = $request->status;

        $language->save();

        return Reply::success(__('app.language').' '.__('menu.settings').' '.__('messages.createdSuccessfully'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $language = LanguageSetting::where('id', $id)->firstOrFail();

        return view('super-admin.language-settings.edit', compact('language'));
    }

    public function update(StoreLanguage $request, $id){
        $language = LanguageSetting::findOrFail($id);

        if ($language->language_code === 'en') {
            return Reply::error(__('modules.languageSettings.defaultLanguageCannotBeModified'));
        }

        // check and create lang folder
        $langExists = File::exists($this->langPath.'/'.strtolower($request->language_code));

        if (!$langExists) {
            // update lang folder name
            File::move($this->langPath.'/'.$language->language_code, $this->langPath.'/'.strtolower($request->language_code));

            Translation::where('locale', $language->language_code)->get()->map(function ($translation) {
                $translation->delete();
            });
        }
        if ($language->language_code === $this->global->locale) {
            $this->global->locale = strtolower($request->language_code);
            $this->global->save();

            $language->status = 'enabled';
        }
        else {
            $language->status = $request->status;
        }

        $language->language_name = ucfirst(strtolower($request->language_name));
        $language->language_code = strtolower($request->language_code);

        $language->save();

        return Reply::success(__('app.language').' '.__('menu.settings').' '.__('messages.updatedSuccessfully'));
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $languages = LanguageSetting::select('id', 'language_code', 'status')->get();

        $language = $languages->first(function ($language, $key) use ($id) {
            return $language->id == $id;
        });

        if ($language->language_code === 'en') {
            return Reply::error(__('modules.languageSettings.defaultLanguageCannotBeModified'));
        }

        // change locale to default
        if ($this->global->locale == $language->language_code) {
            $this->global->locale = 'en';
            // enable status of english language
            $language = $languages->first(function ($language, $key) {
                return $language->language_code == 'en';
            });
            
            $language->status = 'enabled';
            $language->save();
        }
        $this->global->save();

        LanguageSetting::destroy($id);

        return Reply::success(__('messages.recordDeleted'));
    }

    public function changeStatus(Request $request, $id)
    {
        if (!$request->has('status')) {
            $request->request->add(['status' => 'disabled']);
        }
        $language = LanguageSetting::findOrFail($id);

        $language->status = $request->status;
        if ($request->status == 'disabled' && $language->language_code == $this->global->locale) {
            $this->global->locale = 'en';
        }

        $language->save();
        $this->global->save();

        return Reply::success(__('app.language').' '.__('menu.settings').' '.__('messages.updatedSuccessfully'));
    }

    public function changeLanguage(Request $request) {
        $setting = Company::first();
        $setting->locale = $request->input('lang');
        $setting->save();

        return Reply::success(__('messages.languageSettings.changedSuccessfully'));
    }
}
