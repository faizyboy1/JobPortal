<?php

use Illuminate\Database\Seeder;
use App\Skill;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = \App\Company::first();

        Skill::create(['name' => 'Angular JS', 'category_id' => 1, 'company_id' => $company->id]);
        Skill::create(['name' => 'Vue.JS', 'category_id' => 1, 'company_id' => $company->id]);
        Skill::create(['name' => 'Laravel 5.4', 'category_id' => 1, 'company_id' => $company->id]);
        Skill::create(['name' => 'English', 'category_id' => 3, 'company_id' => $company->id]);
        Skill::create(['name' => 'Blogging', 'category_id' => 2, 'company_id' => $company->id]);
    }
}
