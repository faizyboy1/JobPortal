<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Laravel\Cashier\Billable;
use Illuminate\Notifications\Notifiable;
use Stripe\Invoice as StripeInvoice;
use Laravel\Cashier\Invoice;

class Company extends Model
{
    use Notifiable, Billable;

    protected $appends = [
        'logo_url',
        'login_background_image_url'
    ];

    protected $dates = ['licence_expire_on', 'featured_start_date', 'featured_end_date'];


//    public function findInvoice($id)
//    {
//        try {
//            $stripeInvoice = StripeInvoice::retrieve(
//                $id,
//                $this->getStripeKey()
//            );
//
//            $stripeInvoice->lines = StripeInvoice::retrieve($id, $this->getStripeKey())
//                ->lines
//                ->all(['limit' => 1000]);
//
//            $stripeInvoice->date = $stripeInvoice->created;
//            return new Invoice($this, $stripeInvoice);
//        } catch (Exception $e) {
//            //
//        }
//    }

    protected static function boot()
    {
        parent::boot();

        if (auth()->check()) {
            static::addGlobalScope('company', function (Builder $builder) {
                $builder->where('companies.id', user()->company_id);
            });
        }
    }



    public function getLogoUrlAttribute()
    {
        if (is_null($this->logo)) {
            return asset('assets/logo-not-found.png');
        }
        return asset_url('company-logo/' . $this->logo);
    }

    public function application()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function packages()
    {
        return $this->hasMany(CompanyPackage::class, 'company_id');
    }

    public function isFeatured()
    {
        $currentDate = Carbon::now($this->timezone)->format('Y-m-d');
        return Company::where('status', 'active')
            ->where(function ($query) use ($currentDate) {
                $query->whereNull('featured_start_date')
                    ->orWhere(DB::raw('DATE(`featured_start_date`)'), '<=', $currentDate);
            })
            ->where(function ($query) use ($currentDate) {
                $query->whereNull('featured_end_date')
                    ->orWhere(DB::raw('DATE(`featured_end_date`)'), '>=', $currentDate);
            })
            ->where(function ($query) use ($currentDate) {
                $query->whereNull('licence_expire_on')
                    ->orWhere(DB::raw('DATE(`licence_expire_on`)'), '>=', $currentDate);
            })
            ->where('featured', 1)->where('id', $this->id)->first();
    }

    public function setSubDomainAttribute($value)
    {
        // domain is added in the request Class
        $this->attributes['sub_domain'] = strtolower($value);
    }

    public function getLoginBackgroundImageUrlAttribute()
    {
        if (is_null($this->login_background)) {
            $global = GlobalSetting::first();
            return $global->login_background_image_url;
        }
        return asset_url('login-background-image/' . $this->login_background);
    }
}
