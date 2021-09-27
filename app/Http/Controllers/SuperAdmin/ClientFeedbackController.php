<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\ClientFeedback;
use App\Http\Requests\SuperAdmin\StoreClientFeedback;
use App\Helper\Reply;
use App\LanguageSetting;

class ClientFeedbackController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageIcon = 'icon-screen-desktop';
        $this->pageTitle = 'menu.clientFeedbacks';
    }

    public function index() {
        $this->feedbacks = ClientFeedback::with('language:id,language_name')->get();
        $this->activeLanguages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        return view('super-admin.feedback.index', $this->data);
    }

    public function store(StoreClientFeedback $request) {
        $feedback = new ClientFeedback();
        $feedback->client_title = $request->client_title;
        $feedback->feedback = $request->feedback;
        $feedback->language_settings_id = $request->language;
        $feedback->save();

         return Reply::redirect(route('superadmin.client-feedbacks.index'), __('menu.clientFeedbacks') . ' ' . __('messages.updatedSuccessfully'));
    }

    public function edit($id) {
        $this->feedback = ClientFeedback::with('language:id,language_name,status')->where('id', $id)->first();
        $this->activeLanguages = LanguageSetting::where('status', 'enabled')->orderBy('language_name', 'asc')->get();

        return view('super-admin.feedback.edit', $this->data);
    }


    public function update(StoreClientFeedback $request, $id) {
        $feedback = ClientFeedback::findOrFail($id);
        $feedback->client_title = $request->client_title;
        $feedback->feedback = $request->feedback;
        $feedback->language_settings_id = $request->language;
        $feedback->save();

         return Reply::redirect(route('superadmin.client-feedbacks.index'), __('menu.clientFeedbacks') . ' ' . __('messages.updatedSuccessfully'));
    }

    public function destroy($id) {
        ClientFeedback::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }
}
