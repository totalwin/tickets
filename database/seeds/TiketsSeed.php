<?php

use Illuminate\Database\Seeder;

class TiketsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(App\Ticket::class, 300)->create();
    }
}
