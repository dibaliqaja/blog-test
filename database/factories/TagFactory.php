<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tag;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name'  => $faker->unique()->sentence(1, true),
        'slug'  => Str::slug($faker->unique()->sentence(1, true)),
    ];
});
