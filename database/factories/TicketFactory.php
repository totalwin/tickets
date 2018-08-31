<?php

use Faker\Generator as Faker;
use App\User;

$factory->define(App\Ticket::class, function (Faker $faker) {
    return [
        'status' => 1,
        'title' => str_random(30),
        'msg' =>  str_random(300),
        'user_id' => User::inRandomOrder()->first()->id
    ];
});

