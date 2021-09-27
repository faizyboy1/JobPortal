<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Module;
use App\Role;
use App\Permission;

class AddCompanyPermissionInModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       $module = new Module();
                $module->module_name = 'job company';
                $module->description = '';
                $module->save();

        $permissions = [
            ['name' => 'add_job_company', 'display_name' => 'Add Job Company', 'module_id' => $module->id],
            ['name' => 'view_job_company', 'display_name' => 'View Job Company', 'module_id' => $module->id],
            ['name' => 'edit_job_company', 'display_name' => 'Edit Job Company', 'module_id' => $module->id],
            ['name' => 'delete_job_company', 'display_name' => 'Delete Job Company', 'module_id' => $module->id],
        ];

        $admin = Role::where('name', 'admin')->first();

        foreach ($permissions as $permission){

            $create = Permission::create($permission);
            $admin->attachPermission($create);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('module', function (Blueprint $table) {
            //
        });
    }
}
