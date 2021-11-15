<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company_category;
use App\Helper\Reply;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Company\StoreCategoryCompany;

class AdminJobsCategoryController extends SuperAdminBaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = __('menu.companies');
        $this->pageIcon = 'icon-badge';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $this->totalCategory = Company_category::count();
        $this->categories = Company_category::get();
        return view('admin.jobs-category.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
        return view('admin.jobs-category.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
         'company_name' => 'required'
        ]);
        
        $data = $request->all();
        
        Company_category::create($data);

        return Reply::redirect(route('superadmin.job-category.index'), __('menu.companies') . ' ' . __('messages.createdSuccessfully'));
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
        $this->categories = Company_category::find($id);
        return view ("admin.jobs-category.edit", $this->data);
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
        
       $this->validate($request, [
        "company_name" => "required"
       ]);
       $data = $request->all();
       $edit_category = Company_category::find($id);
       $edit_category->update($data);

       return Reply::redirect(route('superadmin.job-category.index'), __('menu.companies') . ' ' . __('messages.updatedSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $category = Company_category::find($id);
       $category->delete();
       return redirect()->route('superadmin.job-category.index')->with('success','Your Record Deleted Successfully');
    }
  
}
