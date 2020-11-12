<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title'             => $faker->sentence(3, true),
        'slug'              => Str::slug($faker->sentence(3, true)),
        'short_description' => $faker->sentence(5, true),
        'content'           => $faker->text,
        'image'             => $faker->image(public_path('storage/images'), 640, 480, null, false),
        'thumbnail'         => $faker->image(public_path('storage/thumbnails'), 250, 200, null, false),
        'category_id' => function () {
            return factory(App\Category::class)->create()->id;
        },
    ];
});
