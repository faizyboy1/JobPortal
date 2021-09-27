<?php

use Faker\Generator as Faker;
use App\JobApplication;

$factory->define(JobApplication::class, function (Faker $faker) {
    return [
        'column_priority' => 0,
        'cover_letter' => $faker->text,
        'email' => $faker->email,
        'full_name' => $faker->name,
        'job_id' => rand(1,3),
        'phone' => $faker->phoneNumber,
        'status_id' => rand(1,5),
        'company_id' => 1
    ];
});
