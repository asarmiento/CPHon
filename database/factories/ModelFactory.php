<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(AccountHon\Entities\Affiliate::class, function ($faker) {
    return [
        'code'=>$faker->randomNumber(5),
        'charter'=>str_random(18), 
        'fname'=>$faker->firstName,
        'flast'=>$faker->lastName, 
        'slast'=>$faker->lastName, 
    'address'=>$faker->address, 
    'homePhone'=>$faker->phoneNumber,
    'affiliation'=>$faker->date,
    'birthdate'=>$faker->date, 
  	'maritalStatus'=>$faker->randomElement(['Casado','Soltero']),
  	 'status'=>'activo',
  	 'token'=>$faker->md5(str_random(2)),
    ];
});
