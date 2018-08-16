<?php

use App\Models\Booking;
use Faker\Generator as Faker;

$factory->define(Booking::class, function (Faker $faker) {
    return [
        '_fk_property'  => factory(\App\Models\Property::class)->create()->id,
        'start_date' => $faker->date('Y-m-d'),
        'end_date' => $faker->date('Y-m-d', '+7 days')
    ];
});