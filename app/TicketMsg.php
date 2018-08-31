<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketMsg extends Model
{
    public function ticket()
	{
	    return $this->belongsTo('App\Ticket', 'ticket_id');
	}

	public function user()
    {
        return $this->belongsTo('App\User')->select(array('id', 'name'));
    }
    
}
