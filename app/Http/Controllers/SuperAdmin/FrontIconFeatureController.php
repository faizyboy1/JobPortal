<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\FrontIconFeature;
use App\Helper\Reply;
use App\Http\Requests\SuperAdmin\StoreIconFeature;
use App\LanguageSetting;

class FrontIconFeatureController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageIcon = 'icon-screen-desktop';
        $this->pageTitle = 'menu.iconFeatures';
    }

    public function index() {
        $this->features = FrontIconFeature::with('language:id,language_name')->get();
        $this->activeLanguages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        return view('super-admin.icon-feature.index', $this->data);
    }

    public function store(StoreIconFeature $request) {
        $feature = new FrontIconFeature();
        $feature->title = $request->title;
        $feature->description = $request->description;
        $feature->icon = $request->icon;
        $feature->language_settings_id = $request->language;
        $feature->save();

         return Reply::redirect(route('superadmin.icon-features.index'), __('menu.iconFeatures') . ' ' . __('messages.updatedSuccessfully'));
    }

    public function edit($id) {
        $this->feature = FrontIconFeature::with('language:id,language_name,status')->where('id', $id)->first();
        $this->activeLanguages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        return view('super-admin.icon-feature.edit', $this->data);
    }


    public function update(StoreIconFeature $request, $id) {
        $feature = FrontIconFeature::findOrFail($id);
        $feature->title = $request->title;
        $feature->description = $request->description;
        $feature->icon = $request->icon;
        $feature->language_settings_id = $request->language;
        $feature->save();

         return Reply::redirect(route('superadmin.icon-features.index'), __('menu.iconFeatures') . ' ' . __('messages.updatedSuccessfully'));
    }

    public function destroy($id) {
        FrontIconFeature::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }
}
