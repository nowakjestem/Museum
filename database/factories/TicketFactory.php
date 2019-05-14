<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Ticket::class, function (Faker $faker) {
    return [
        'course_id' => function() {
            return factory(\App\Models\Course::class)->create()->id;
        },
        'quantity' => $faker->numerify('#'),
    ];
});
