<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name'  => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'slug'  => Str::slug($faker->sentence($nbWords = 6, $variableNbWords = true)),
    ];
});
