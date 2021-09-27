<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\User;
use App\ThemeSetting;

class AddIsSuperadminColumnUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_superadmin')->default(false)->before('created_at');
        });

        $superadmin = new User();
        $superadmin->is_superadmin = true;
        $superadmin->name = 'Superadmin name';
        $superadmin->email = 'superadmin@example.com';
        $superadmin->password = bcrypt('123456');
        $superadmin->save();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_superadmin']);
        });
    }
}
