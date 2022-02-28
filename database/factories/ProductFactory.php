<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Product::class, function (Faker $faker) {
    $price = $faker->numberBetween(1000 , 100000);
    return [
        'name' => $faker->unique()->name,
        'price' => $price ,
        'discount_price' => $faker->boolean ? $faker->numberBetween(10 , $price / 10) : 0,
    ];
});
