<?php

namespace App\Http\Controllers\SuperAdmin;

use App\FooterMenu;
use App\FooterSetting;
use App\Helper\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Http\Requests\SuperAdmin\FooterSetting\StoreMenuRequest;
use App\Http\Requests\SuperAdmin\FooterSetting\StoreRequest;
use App\Http\Requests\SuperAdmin\FooterSetting\UpdateMenuRequest;
use App\LanguageSetting;
use App\SeoDetail;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SuperAdminFooterSettingsController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.footerSettings';
        $this->pageIcon = 'ti-settings';
    }

    public function index(Request $request)
    {
        $this->footerSettings = FooterSetting::select('id', 'social_links', 'footer_copyright_text')->first();
        $this->activeLanguages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        if ($request->ajax()) {
            $footerSettings = FooterSetting::select('id', 'language_settings_id', 'footer_copyright_text')->where('language_settings_id', $request->language_settings_id)->first();

            $view = view('super-admin.footer-settings.copyright-input', ['footerSettings' => $footerSettings, 'languageId' => $request->language_settings_id])->render();

            return Reply::dataOnly(['status' => 'success', 'view' => $view]);
        }

        return view('super-admin.footer-settings.index', $this->data);
    }

    public function create()
    {
        $activeLanguages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        return view('super-admin.footer-settings.create', compact('activeLanguages'));
    }

    public function edit($id)
    {
        $this->footerMenu = FooterMenu::select('id', 'language_settings_id', 'name', 'description')->where('id', $id)->with('seo_details')->first();
        $this->activeLanguages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        return view('super-admin.footer-settings.edit', $this->data);
    }

    public function data()
    {
        $footerMenus = FooterMenu::with('language')->get();

        return DataTables::of($footerMenus)
            ->addColumn('action', function ($row) {
                $action = '';

                $action .= ' <a href="javascript:updateNewFooterMenuSetting(' . $row->id . ');" class="btn btn-primary btn-circle"
                    data-toggle="tooltip" data-original-title="' . __('app.edit') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

                $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                    data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="' . __('app.delete') . '"><i class="fa fa-times" aria-hidden="true"></i></a>';
                return $action;
            })
            ->editColumn('name', function ($row) {
                return $row->name;
            })
            ->editColumn('description', function ($row) {
                return html_entity_decode($row->description);
            })
            ->editColumn('language', function ($row) {
                return ucfirst($row->language->language_name);
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(StoreRequest $request){
        $setting = FooterSetting::first();
        
        $links = [];
        foreach ($request->social_links as $name => $value) {
            $link_details=[];
            $link_details = Arr::add($link_details, 'name', $name);
            $link_details = Arr::add($link_details, 'link', $value);
            array_push($links, $link_details);
        }
        
        $setting->social_links = $links;
        
        if ($request->language === 'en') {
            $setting->footer_copyright_text = $request->footer_copyright_text;
        } else {
            FooterSetting::updateOrCreate([
                'language_settings_id' => $request->language
            ], [
                'footer_copyright_text' => $request->footer_copyright_text
            ]);
        }
        
        $setting->save();

        return Reply::success(__('messages.footerSettingUpdatedSuccessfully'));
    }

    public function storeFooterMenu(StoreMenuRequest $request)
    {
        $footer = new FooterMenu();
        $footer->language_settings_id = $request->language;
        $footer->name = $request->title;
        $footer->slug = Str::slug($request->title);
        $footer->description = $request->description;
        $footer->save();

        SeoDetail::create(
            [
                'footer_menu_id' => $footer->id,
                'seo_title' => $request->seo_title,
                'seo_description' => $request->seo_description,
                'seo_author' => $request->seo_author,
                'seo_keywords' => $request->seo_keywords
            ]
        );

        return Reply::success(__('messages.createdSuccessfully'));
    }

    public function updateFooterMenu(UpdateMenuRequest $request, $id)
    {
        $footer = FooterMenu::findOrFail($id);
        $footer->language_settings_id = $request->language;
        $footer->name = $request->title;
        $footer->slug = Str::slug($request->title);
        $footer->description = $request->description;
        $footer->save();

        SeoDetail::where('footer_menu_id', $footer->id)->update(
            [
                'seo_title' => $request->seo_title,
                'seo_description' => $request->seo_description,
                'seo_author' => $request->seo_author,
                'seo_keywords' => $request->seo_keywords
            ]
        );

        return Reply::success(__('messages.updatedSuccessfully'));
    }

    public function destroy(Request $request, $id)
    {
        $footerMenu = FooterMenu::findOrFail($id);

        $footerMenu->delete();

        return Reply::success(__('messages.recordDeleted'));
    }
}
