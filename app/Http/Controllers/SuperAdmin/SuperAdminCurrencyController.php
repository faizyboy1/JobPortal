<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Currency;
use App\Http\Requests\SuperAdmin\StoreCurrency;
use App\Helper\Reply;

class SuperAdminCurrencyController extends SuperAdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->pageTitle = 'currencySetting';
        $this->pageIcon = __('ti-settings');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->currencies = Currency::all();
        return view('super-admin.currencies.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('super-admin.currencies.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCurrency $request)
    {
        $currency = new Currency();
        $currency->currency_symbol = $request->currency_symbol;
        $currency->currency_code = $request->currency_code;
        $currency->currency_name = $request->currency_name;
        $currency->save();

        return Reply::redirect(route('superadmin.currency-settings.index'), __('messages.createdSuccessfully'));
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
        $this->currency = Currency::findOrFail($id);
        return view('super-admin.currencies.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCurrency $request, $id)
    {
        $currency = Currency::findOrFail($id);
        $currency->currency_symbol = $request->currency_symbol;
        $currency->currency_code = $request->currency_code;
        $currency->currency_name = $request->currency_name;
        $currency->save();

        return Reply::redirect(route('superadmin.currency-settings.index'), __('messages.createdSuccessfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Currency::destroy($id);
        return Reply::success(__('messages.recordDeleted'));
    }
}
