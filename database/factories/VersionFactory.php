<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Version;
use Faker\Generator as Faker;

$factory->define(Version::class, function (Faker $faker) {

    static $number = 1;

    return [
        'version' => 'v' . $number++ . '.' . $faker->numberBetween(0, 99) . '.' . $faker->numberBetween(0, 99),
        'log'  => $faker->sentence(64, true),
        'update' => $faker->randomElement([1, 0,]),
        'updateForce' => $faker->randomElement([1, 0,]),
        'updateLang' => $faker->randomElement([1, 0,])
    ];
});
