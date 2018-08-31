<?php

use Illuminate\Database\Seeder;

class TicketMsgSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $TicketMsg = factory(App\TicketMsg::class, 800)->create();
    }
}
