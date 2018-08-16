<?php

use App\Models\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        '_fk_location'  => factory(\App\Models\Location::class)->create()->id,
        'property_name' => $faker->name,
        'near_beach'    => $faker->boolean,
        'accepts_pets' => $faker->boolean,
        'sleeps' => $faker->numberBetween(1, 10),
        'beds' => $faker->numberBetween(1, 10)
    ];
});