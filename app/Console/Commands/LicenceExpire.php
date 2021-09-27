<?php

namespace App\Console\Commands;

use App\Company;
use App\CompanyPackage;
use App\Currency;
use App\ModuleSetting;
use App\Notifications\LicenseExpire;
use App\Notifications\LicenseExpireBefore;
use App\Notifications\LicenseExpirePre;
use App\Notifications\TaskCompleted;
use App\Package;
use App\PackageSetting;
use App\Setting;
use App\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class LicenceExpire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'licence-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set licence expire status of companies in companies table.';

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $activePackageBefore = CompanyPackage::with(['package'])
            ->where('status', 'active')
             ->where(function($query){
                $query->whereRaw('DATE(end_date) = ?', [Carbon::now()->addDay()->format('Y-m-d')]);
                $query->orWhereNull('end_date');
            })
            ->groupBy('company_id')
            ->get();

        $activePackageAfter = CompanyPackage::with(['package'])
            ->where('status', 'active')
             ->where(function($query){
                $query->whereRaw('DATE(end_date) = ?', [Carbon::now()->subDay()->format('Y-m-d')]);
                $query->orWhereNull('end_date');
            })
            ->groupBy('company_id')
            ->get();

        // Set default package for license expired companies.
        if($activePackageBefore){
            foreach($activePackageBefore as $package){
                $company = Company::findOrFail($package->company_id);
                if($company->company_email){
                    $companyUser = User::join('role_user', 'role_user.user_id', '=', 'users.id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->where('users.company_id', $company->id)
                        ->where('roles.name', 'admin')->first();

                    $companyUser->notify(new LicenseExpireBefore(($companyUser)));
                }
            }
        }

        // Set default package for license expired companies.
        if($activePackageAfter){
            foreach($activePackageAfter as $package){
                $company = Company::findOrFail($package->company_id);
                if($company->company_email){
                    $companyUser = User::join('role_user', 'role_user.user_id', '=', 'users.id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->where('users.company_id', $company->id)
                        ->where('roles.name', 'admin')->first();

                    $companyUser->notify(new LicenseExpire(($companyUser)));
                }
            }
        }
    }
}
