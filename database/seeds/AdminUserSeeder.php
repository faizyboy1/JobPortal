<?php

use Illuminate\Database\Seeder;
use App\Company;
use App\CompanyPackage;
use App\Package;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::first();
        $package = Package::first();

        $admin = new \App\User();
        $admin->name = 'Admin';
        $admin->company_id = $company->id;
        $admin->email = 'admin@example.com';
        $admin->password = \Illuminate\Support\Facades\Hash::make('123456');
        $admin->save();

        $companyPackage = new CompanyPackage();
        $companyPackage->company_id = $company->id;
        $companyPackage->package_id = $package->id;
        $companyPackage->status = 'active';
        $companyPackage->start_date = Carbon::today()->format('Y-m-d');
        $companyPackage->end_date = Carbon::today()->addDays($package->trial_duration)->format('Y-m-d');
        $companyPackage->save();
    }
}
