@extends('layouts.app')

@section('content')
	<h3>Создание тикета</h3>	
	
	<br>

	@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif

	<form method="POST" action="{{ route('storeTicket') }}">
    	@csrf

    	<div class="input-group mb-3">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="inputGroup-sizing-default">Заголовок</span>
		  </div>
		  <input type="text" class="form-control" aria-label="Default" aria-describedby="" name="title" required="">
		</div>
    	<br>
    	<div class="input-group">
		  <div class="input-group-prepend">
		    <span class="input-group-text">Текст сообщения</span>
		  </div>
		  <textarea name="msg" class="form-control  mr-5" aria-label="With textarea" required=""></textarea>
		</div>
 
    	<br>
    	<input type="submit" class="btn btn-primary" name="">
    	
	</form>

@stop