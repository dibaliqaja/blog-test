<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title'             => $faker->unique()->sentence(3, true),
        'slug'              => Str::slug($faker->unique()->sentence(3, true)),
        'short_description' => $faker->sentence(5, true),
        'content'           => $faker->text,
        'image'             => $faker->image(public_path('storage/images'), 780, 580, null, false),
        'thumbnail'         => $faker->image(public_path('storage/thumbnails'), 380, 180, null, false),
        'category_id' => function () {
            return factory(App\Category::class)->create()->id;
        },
        'users_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});
