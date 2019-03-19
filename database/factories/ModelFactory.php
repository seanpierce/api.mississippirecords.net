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

$factory->define(App\Models\Token::class, function (Faker\Generator $faker) {
    return [
        'user_id' => 1,
        'token' => bin2hex(random_bytes(16)) . "-" . time(),
    ];
});

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'class' => 'ADMIN',
        'shipping_address' => '123 W Test St.',
        'shipping_city' => 'Portland',
        'shipping_state' => 'OR',
        'shipping_zip' => '97211',
        'business_name' => 'Testman Records',
        'created_at' => date("Y-m-d H:i:s"),
        'updated_at' => date("Y-m-d H:i:s"),
        'approved_date' => date("Y-m-d H:i:s")
		];
});
