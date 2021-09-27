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

class DeleteAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete company account.';

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
        $currentDate = Carbon::now();
        $companies = Company::where('status', 'active')
            ->whereRaw("delete_account_at < '$currentDate'")
            ->whereNotNull("delete_account_at")
            ->get();
        foreach ($companies as $company){
            $company->status = 'inactive';
            $company->save();
        }
    }
}
