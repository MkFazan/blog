<?php

use App\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Page::class, function (Faker $faker) {
    return [
        "name" => "name",
        "meta_title" => $faker->title,
        "slug" => $faker->slug,
        "meta_keywords" => $faker->text(255),
        "meta_description" => $faker->text(150),
        "text" => $faker->text(500),
        "status" => STATUS_ACTIVE
    ];
});
