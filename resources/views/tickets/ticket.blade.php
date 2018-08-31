@extends('layouts.app')

@section('content')
	<h3 style="width: 150px;">Тикет #{{$ticket->id}} </h3>   
	<div class="w-30 border float-left pr-3">Пользователь  </div>
		<div class="w-70 border">{{$ticket->user->name}} ({{$ticket->user->id}})</div>
	<div class="w-30 border float-left pr-3">Заголовок  </div>	
	<div class="w-70 border" >{{$ticket->title}}</div>
	<div class="w-20 border float-left pr-3">Сообщение  </div>
	<div class="w-70 border " style="word-wrap: break-word;">{{$ticket->msg}}</div>
	<h2>Переписка:</h2>

	@foreach ($ticket->msges as $msg)
		<div class="w-30 border float-left pr-3">Пользователь  </div>
		<div class="w-70 border">{{ $msg->user->name }} ({{$msg->user_id}})</div>
		<div class="w-20 border float-left pr-3">Сообщение:  </div>
		<div class="w-70 border " style="word-wrap: break-word;">
			{{$msg->msg_text}}</div>

		<br>
	@endforeach

	<br>
	<h4>Форма ответа:</h3>
	<form method="POST" action="{{ route('storeMsg',[$ticket->id]) }}">
    	@csrf    	
    	<textarea name="msg_text" class="w-100 mr-5" required=""></textarea>
    	<br>
    	<input type="submit" class="btn btn-primary" name="">

	</form>

	 <br>
	<a class="btn btn-danger mb-4" href="{{ route('closeTicket',[$ticket->id]) }}" role="button">Закрыть тикет</a>

@stop