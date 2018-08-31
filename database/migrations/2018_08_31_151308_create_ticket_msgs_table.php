<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketMsgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_msgs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ticket_id')->index();
            $table->integer('user_id');
            $table->text('msg_text');            
            $table->timestamps();

            // $table->foreign('ticket_id')->references('id')->on('tickets');
        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_msgs');
    }
}
