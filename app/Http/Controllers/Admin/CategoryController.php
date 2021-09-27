<?php

namespace App\Http\Controllers\Admin;

use App\Helper\Reply;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Category;
use App\Http\Requests\Category\StoreCategory;

class CategoryController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('admin.zoom.category.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $this->categories = Category::all();
        return view('admin.zoom.category.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(StoreCategory $request)
    {
        $category = new Category();
        $category->category_name = $request->category_name;
        $category->save();
        $categoryData = Category::all();
        return Reply::successWithData(__('messages.categoryAdded'),['data' => $categoryData]);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        Category::destroy($id);
        $categoryData = Category::all();
        return Reply::successWithData(__('messages.categoryDeleted'),['data' => $categoryData]);
    }
}
