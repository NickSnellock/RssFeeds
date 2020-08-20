<?php
/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Entities\RssFeed;
use Faker\Generator as Faker;

$factory->define(RssFeed::class, function (Faker $faker) {
    return [
        'user_id' => factory(App\User::class),
        'rss_url' => $faker->unique()->url,
    ];
});
