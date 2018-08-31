<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    
    const STATUSES = [
    	1 => "Новый",
    	2 => "В процессе",
    	3 => "Прочитан",
    	4 => "Ожидает ответа пользователя",
    	5 => "Закрыт",
    ];


    static public function getStatuses(){

    	return  self::STATUSES;

    }

    public function user()
    {
        return $this->belongsTo('App\User')->select(array('id', 'name'));
    }

    public function msges()
    {
        return $this->hasMany('App\TicketMsg')->orderBy("created_at");
    }

}
