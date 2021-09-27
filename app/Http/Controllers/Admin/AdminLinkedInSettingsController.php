<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\Helper\Reply;
use App\LinkedInSetting;
use Illuminate\Http\Request;

class AdminLinkedInSettingsController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle ='menu.linkedInSettings';
        $this->pageIcon = 'icon-settings';
    }

    public function index(){
        $linkedinGlobal = LinkedInSetting::first();
        if($linkedinGlobal->status == 'disable')
        {
            abort(404);
        }
        $this->linkedInSetting = Company::select('id', 'linkedin')->where('id', $this->user->company_id)->first();
        return view('admin.linked-in-settings.edit', $this->data);
    }

    public function update(Request $request, $id){
        /*dd($request->all());*/
        $company = Company::findOrFail($id);
        $company->linkedin = $request->status == "on" ? 'enable' : 'disable';

        $company->save();

        return Reply::redirect(route('admin.linkedin-settings.index'), __('menu.settings').' '.__('messages.updatedSuccessfully'));
    }
}
