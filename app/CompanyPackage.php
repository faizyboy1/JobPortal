<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompanyPackage extends Model
{
    protected $dates = ['start_date', 'end_date'];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function stripe()
    {
        return $this->belongsTo(StripeInvoice::class, 'stripe_id');
    }

    public function paypal()
    {
        return $this->belongsTo(PaypalInvoice::class, 'paypal_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public static function activePackage($companyId)
    {
        return CompanyPackage::where('company_id', $companyId)
            ->where('status', 'active')
            ->where(function ($query) {
                $query->where(DB::raw('DATE(end_date)'), '>=', DB::raw('CURDATE()'));
                $query->orWhereNull('end_date');
            })
            ->first();
    }
}
