<?php

use App\ApplicationStatus;
use App\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSlugColumnApplicationStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_status', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('status');
        });
        $companies = Company::select('id')->get();

        foreach ($companies as $company) {
            $statuses = ApplicationStatus::select('id', 'company_id', 'status', 'slug','position', 'color')->where('company_id', $company->id)->get();
            
            $slug = ['applied', 'phone screen', 'interview', 'hired', 'rejected'];
    
            foreach ($statuses as $key => $status) {
                $status->slug = $slug[$key];
    
                $status->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('application_status', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
}
