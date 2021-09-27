<?php

namespace App\Http\Controllers\Admin;

use App\ApplicationSetting;
use App\Helper\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ApplicationSettingsController extends AdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'menu.applicationFormSettings';
        $this->pageIcon = 'icon-settings';
        $this->middleware(function ($request, $next) {
            $this->setting = ApplicationSetting::first();
            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(! $this->user->cans('manage_settings'), 403);
        $this->timezones = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);
        $this->settings = ApplicationSetting::where('company_id', company()->id)->first();
        if(!$this->setting){
            abort(404);
        }

        return view('admin.application-setting.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $result = $this->setting;
        return $result;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort_if(! $this->user->cans('manage_settings'), 403);
        $mailSetting = [];

        foreach ($this->setting->mail_setting as $id => $setting) {
            $setting['status'] = false;
            if ($request->has('checkBoardColumn') && in_array($id, $request->checkBoardColumn)) {
                $setting['status'] = true;
            }
            $mailSetting = Arr::add($mailSetting, $id, $setting);
        }

        $this->setting->legal_term = $request->input('legal_term');
        $this->setting->mail_setting = $mailSetting;

        $this->setting->save();


        return Reply::success(__('messages.applicationSetting.settingUpdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
