<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Painting::class, function (Faker $faker) {
    return [
        'course_id' => function () {
            return factory(\App\Models\Course::class)->create()->id;
        },
        'author_id' => function () {
            return factory(\App\Models\Author::class)->create()->id;
        },
        'name' => $faker->word,
    ];
});
