<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Company;
use App\Package;

class AlterCompanyPackageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->unsignedInteger('package_id')->nullable()->default(null)->after('id');
            $table->foreign('package_id')
                ->references('id')
                ->on('packages')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('package_type')->nullable()->default(null);
            $table->date('licence_expire_on')->nullable()->default(null);
        });

        DB::statement('ALTER TABLE `company_packages` CHANGE `end_date` `end_date` DATE NULL DEFAULT NULL');

        $trialPackage = Package::where('is_trial', 1)->first();
        $company = Company::first();
        $company->package_id = $trialPackage->id;
        $company->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropForeign(['package_id']);
            $table->dropColumn(['package_id']);
        });
    }
}
