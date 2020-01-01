<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

use App\Media;

$factory->define(Media::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'item' => '',
        'category_id' => ''
    ];
});
