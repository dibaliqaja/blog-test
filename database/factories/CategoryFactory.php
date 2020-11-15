<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name'  => $faker->unique()->sentence(1, true),
        'slug'  => Str::slug($faker->unique()->sentence(1, true)),
    ];
});
