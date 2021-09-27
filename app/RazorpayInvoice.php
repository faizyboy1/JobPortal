<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RazorpayInvoice extends Model
{
    protected $table = 'razorpay_invoices';
    protected $dates = ['pay_date', 'next_pay_date'];

    public function company() {
        return $this->belongsTo(Company::class, 'company_id')->withoutGlobalScopes(['active']);
    }
    public function currency() {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function package() {
        return $this->belongsTo(Package::class, 'package_id');
    }


}
