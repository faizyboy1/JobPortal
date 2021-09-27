<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
use App\RoleUser;
use App\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = \App\Company::first();

        $role = new Role();
        $role->name = "Manager";
        $role->display_name = ucwords('Manager');
        $role->company_id = $company->id;
        $role->save();

        $roleId = $role->id;
        $permissions = Permission::all();

        $role = Role::findOrFail($roleId);
        $role->perms()->sync([]);
        $role->attachPermissions($permissions);

        $users = User::where('id', '>', 1)->get();

        foreach($users as $user){
            $roleUser = new RoleUser();
            $roleUser->user_id = $user->id;
            $roleUser->role_id = $roleId;
            $roleUser->save();
        }
    }
}
