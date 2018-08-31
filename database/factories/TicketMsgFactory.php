<?php

use Faker\Generator as Faker;

use App\Ticket;
use App\User;

$factory->define(App\TicketMsg::class, function (Faker $faker) {
    return [
        'msg_text' => str_random(500),
        'ticket_id' => Ticket::inRandomOrder()->first()->id,
        'user_id' => User::inRandomOrder()->first()->id
    ];
});