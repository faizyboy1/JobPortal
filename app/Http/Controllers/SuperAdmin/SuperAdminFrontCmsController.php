<?php

namespace App\Http\Controllers\SuperAdmin;

use App\FrontCmsHeader;
use App\Helper\Files;
use Illuminate\Http\Request;
use App\Helper\Reply;
use App\FrontImageFeature;
use App\Http\Requests\SuperAdmin\StoreImageFeature;
use App\Http\Requests\SuperAdmin\UpdateHeader;
use App\Http\Requests\SuperAdmin\UpdateImageFeature;
use App\LanguageSetting;

class SuperAdminFrontCmsController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageIcon = 'icon-screen-desktop';
        $this->pageTitle = 'menu.frontCms';
    }

    public function index()
    {
        $this->headerData = FrontCmsHeader::first();
        $this->activeLanguages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();
        
        return view('super-admin.front-cms.index', $this->data);
    }
    public function commonSetting()
    {
        $this->headerData = FrontCmsHeader::first();
        return view('super-admin.front-common-setting.index', $this->data);
    }

    public function changeForm(Request $request)
    {
        $headerData = FrontCmsHeader::where('language_settings_id', $request->language_settings_id)->first();

        if (empty($headerData)) {
            $view = view('super-admin.front-cms.new-form', ['languageId' => $request->language_settings_id])->render();
        } else {
            $view = view('super-admin.front-cms.edit-form', ['headerData' => $headerData])->render();
        }
        
        return Reply::dataOnly(['status' => 'success', 'view' => $view]);
    }

    public function updateCommonHeader(Request $request)
    {
        $data = $request->all();
        $headerData = FrontCmsHeader::first();

        if ($request->hasFile('logo')) {
            $data['logo'] = Files::upload($request->logo,'front-logo');
        }

        if ($request->hasFile('login_background_image')) {
            $headerData->login_background = Files::upload($request->login_background_image,'login-background-image');
        }

        if ($request->hasFile('register_background_image')) {
            $headerData->register_background = Files::upload($request->register_background_image,'register-background-image');
        }

        if ($request->remove_login_background == 'yes') {
            $headerData->login_background = null;
        }

        if ($request->remove_register_background == 'yes') {
            $headerData->register_background = null;
        }

        unset($data['login_background_image']);
        unset($data['register_background_image']);

        $headerData->update($data);

        return Reply::success(__('menu.settings') . ' ' . __('messages.updatedSuccessfully'));
    }

    public function updateHeader(UpdateHeader $request)
    {
        $headerData = FrontCmsHeader::where('language_settings_id', $request->language_settings_id)->first();
        $data = $request->all();

        if ($request->hasFile('header_image')) {
            $data['header_image'] = Files::upload($request->header_image,'header-image');
        }

        if ($request->hasFile('header_backround_image')) {
            $data['header_backround_image'] = Files::upload($request->header_backround_image,'header-background-image');
        }
        if ($request->remove_header_background == 'yes') {
            $data['header_backround_image'] = null;
        }

        if (!is_null($headerData)) {
            $headerData->update($data);
        } else {
            FrontCmsHeader::create($data);
        }

        return Reply::success(__('menu.settings') . ' ' . __('messages.updatedSuccessfully'));
    }

    public function imageFeatures()
    {
        $this->features = FrontImageFeature::with('language:id,language_name,status')
                            ->whereHas('language', function ($query) {
                                $query->where('status', 'enabled');
                            })->get();
        $this->activeLanguages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        return view('super-admin.front-cms.features', $this->data);
    }

    public function saveImageFeatures(StoreImageFeature $request)
    {
        $headerData = new FrontImageFeature();
        $headerData->title = $request->title;
        $headerData->description = $request->description;
        $headerData->language_settings_id = $request->language;

        if ($request->hasFile('image')) {
            $headerData->image = Files::upload($request->image,'front-features');
        }

        $headerData->save();

        return Reply::redirect(route('superadmin.front-cms.features'), __('menu.settings') . ' ' . __('messages.updatedSuccessfully'));
    }

    public function updatefeatures(UpdateImageFeature $request, $id)
    {
        $headerData = FrontImageFeature::findOrFail($id);
        $headerData->title = $request->title;
        $headerData->description = $request->description;
        $headerData->language_settings_id = $request->language;

        if ($request->hasFile('image')) {
            $headerData->image = Files::upload($request->image,'front-features');
        }

        $headerData->save();

        return Reply::redirect(route('superadmin.front-cms.features'), __('menu.settings') . ' ' . __('messages.updatedSuccessfully'));
    }

    public function editImageFeatures($id)
    {
        $this->feature = FrontImageFeature::with('language:id,language_name,status')->where('id', $id)->first();
        $this->activeLanguages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        return view('super-admin.front-cms.edit_feature', $this->data);
    }

    public function deleteFeature(Request $request, $id)
    {
        $feature = FrontImageFeature::findorFail($id);
        Files::deleteFile($feature->image, 'front-features');
        $feature->delete();
        return Reply::success(__('messages.recordDeleted'));
    }

}
