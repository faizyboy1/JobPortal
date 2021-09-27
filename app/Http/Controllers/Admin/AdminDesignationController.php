<?php

namespace App\Http\Controllers\Admin;

use App\Department;
use App\Designation;
use App\Helper\Reply;
use App\Http\Requests\Designation\StoreRequest;
use Illuminate\Http\Request;


class AdminDesignationController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'app.designation';
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

        $this->designations = Designation::all();
        return view('admin.designation.create', $this->data);
    }


    public function edit($id)
    {
       //
    }

    public function store(StoreRequest $request)
    {
        $designation = new Designation;
        $designation->name = $request->name;
        $designation->save();

        $designationData = Designation::all();
        return Reply::successWithData(__('messages.designationAdded'),['data' => $designationData]);
    }

    public function update(StoreRequest $request, $id)
    {
        $designation = Designation::findOrFail($id);
        $designation->name = $request->name;
        $designation->save();

        $designationData = Designation::all();
        return Reply::successWithData(__('messages.designationUpdated'),['data' => $designationData]);
    }

    public function destroy($id)
    {
        Designation::destroy($id);

        $designationData = Designation::all();
        return Reply::successWithData(__('messages.designationDeleted'),['data' => $designationData]);
    }

    public function show($id)
    {
        //
    }
}
