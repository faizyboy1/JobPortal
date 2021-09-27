<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Helper\Reply;
use App\Http\Requests\Department\StoreRequest;
use Illuminate\Http\Request;


class AdminDepartmentController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle ='app.department';
        $this->pageIcon = 'icon-user';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create()
    {
        abort_if(!$this->user->cans('add_job_applications'), 403);

        $this->departments = Department::all();
        return view('admin.department.create', $this->data);
    }


    public function edit($id)
    {
       //
    }

    public function store(StoreRequest $request)
    {
        $department = new Department;
        $department->name = $request->name;
        $department->save();

        $departmentData = Department::all();
        return Reply::successWithData(__('messages.departmentAdded'),['data' => $departmentData]);
    }

    public function update(StoreRequest $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->name = $request->name;
        $department->save();

        $departmentData = Department::all();
        return Reply::successWithData(__('messages.departmentUpdated'),['data' => $departmentData]);
    }

    public function destroy($id)
    {
        Department::destroy($id);

        $departmentData = Department::all();
        return Reply::successWithData(__('messages.departmentDeleted'),['data' => $departmentData]);
    }

    public function show($id)
    {
        //
    }
}
