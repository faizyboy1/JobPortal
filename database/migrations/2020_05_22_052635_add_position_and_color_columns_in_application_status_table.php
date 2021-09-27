<?php

use App\ApplicationStatus;
use App\Company;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPositionAndColorColumnsInApplicationStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('application_status', function (Blueprint $table) {
            $table->smallInteger('position')->after('status')->nullable();
            $table->string('color', 12)->after('position')->nullable();
        });

        $companies = Company::select('id')->get();

        foreach ($companies as $company) {
            $statuses = ApplicationStatus::select('id', 'company_id', 'status','position', 'color')->where('company_id', $company->id)->get();
            
            $position = [1, 2, 3, 4, 5];
            $color = ['#2b2b2b', '#f1e52e', '#3d8ee8', '#32ac16', '#ee1127'];
    
            foreach ($statuses as $key => $status) {
                $status->position = $position[$key];
                $status->color = $color[$key];
    
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
            $table->dropColumn('position');
            $table->dropColumn('color');
        });
    }
}
