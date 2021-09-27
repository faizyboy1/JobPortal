<?php

namespace App\Http\Controllers\SuperAdmin;

use App\ApplicationStatus;
use App\Helper\Reply;
use App\Http\Controllers\SuperAdmin\SuperAdminBaseController;
use App\Http\Requests\StoreJob;
use App\Http\Requests\SuperAdmin\SuperadminUser\StoreRequest;
use App\Http\Requests\SuperAdmin\SuperadminUser\UpdateRequest;
use App\Job;
use App\JobCategory;
use App\JobLocation;
use App\JobSkill;
use App\Question;
use App\Skill;
use App\User;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use App\Company;
use App\JobApplication;
use App\Notifications\NewJobOpening;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class SuperadminController extends SuperAdminBaseController
{
    use AppBoot;

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('app.superadmin');
        $this->pageIcon = 'icon-incognito';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->superadmins = User::where('is_superadmin', 1)->get();
        $this->isCheckScript();
        return view('super-admin.superadmin.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super-admin.superadmin.create', $this->data);
    }

    /**
     * @param StoreRequest $request
     * @return array
     */
    public function store(StoreRequest $request)
    {
        $user = new User();
        $user->is_superadmin = 1;
        $user->email         = $request->email;
        $user->name          = $request->name;
        $user->status        = $request->status;
        $user->password      = Hash::make($request->password);
        $user->save();

        return Reply::redirect(route('superadmin.superadmins.index'), 'messages.superadmin.userCreated');
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
        if($this->user->id == $id){
            abort(403);
        }
        $this->superadminUser = User::findOrFail($id);

        return view('super-admin.superadmin.edit', $this->data);
    }

    /**
     * @param UpdateRequest $request
     * @param $id
     * @return array
     */
    public function update(UpdateRequest $request, $id)
    {
        if($this->user->id == $id){
            abort(403);
        }

        $user = User::findOrFail($id);

        $user->email         = $request->email;
        $user->name          = $request->name;
        $user->status        = $request->status;
        $user->password      = Hash::make($request->password);
        $user->save();

        return Reply::redirect(route('superadmin.superadmins.index'),'messages.superadmin.userUpdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->user->id == $id){
            abort(403);
        }

        User::destroy($id);
        return Reply::success(__('messages.superadmin.userDeleted'));
    }

    /**
     * @return mixed
     */
    public function data()
    {
        $user = User::where('is_superadmin', 1)->get();

        return DataTables::of($user)
            ->addColumn('action', function ($row) {
                $action = '';

                if ($this->user->id != $row->id) {
                    $action .= '<a href="' . route('superadmin.superadmins.edit', [$row->id]) . '" class="btn btn-primary btn-circle"
                      data-toggle="tooltip" data-original-title="' . __('app.edit') . '"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

                    $action .= ' <a href="javascript:;" class="btn btn-danger btn-circle sa-params"
                      data-toggle="tooltip" data-row-id="' . $row->id . '" data-original-title="' . __('app.delete') . '"><i class="fa fa-times" aria-hidden="true"></i></a>';
                }
                return $action;
            })
            ->editColumn('name', function ($row) {
                return ucfirst($row->name);
            })
            ->editColumn('email', function ($row) {
                return ucfirst($row->email);
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'active') {
                    return '<label class="badge bg-success">' . __('app.active') . '</label>';
                }
                if ($row->status == 'inactive') {
                    return '<label class="badge bg-danger">' . __('app.inactive') . '</label>';
                }
            })
            ->rawColumns(['status', 'action'])
            ->addIndexColumn()
            ->make(true);
    }
}
