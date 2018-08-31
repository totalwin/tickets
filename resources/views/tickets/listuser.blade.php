
@extends('layouts.app')

@section('content')

  <a class="btn btn-success mb-4" href="{{ route('createTicket') }}" role="button">Создать тикет</a>


  @if ($filter != 666)
  <form method="GET" class="float-rigth" action="{{route('tickets')}}"> 

    <select name="filter" class="form-control mb-3">
      <option value="1" @if ($filter == 1) selected="" @endif  >Новый</option>
      <option value="2" @if ($filter == 2) selected="" @endif>В процессе</option>
      <option value="3" @if ($filter == 3) selected="" @endif>Прочитан</option>
      <option value="4" @if ($filter == 4) selected="" @endif>Ожидает ответа пользователя</option>
      <option value="5" @if ($filter == 5) selected="" @endif>Закрыт</option>
      <option value="6" @if ($filter == 6) selected="" @endif>Без ответа > месяца</option>
    </select>

    <input type="submit" class="btn btn-primary" name="" value="Фильтровать">

  </form>
  @endif

  <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Статус</th>
      <th scope="col">Заголовок</th>
      <th scope="col">Обновлен</th>
      <th scope="col">Просмотр</th>
    </tr>
  </thead>
  <tbody>
  	@foreach ($tickets as $ticket)

    <tr>
      <th scope="row">{{$ticket->id}}</th>
      <td>{{ $statuses[$ticket->status] }}</td>
      <td>{{$ticket->title }}</td>
      <td>{{$ticket->updated_at }}</td>
      <td><a class="btn btn-default" href="{{route('ticket',['id'=>$ticket->id] )}}">
							<i class="fas fa-edit"></i></a>	</td>

    </tr>
    @endforeach

  </tbody>
  <tfoot>
			<tr>
				<td colspan="3">
					<ul class="pagination pull-right">
						{{$tickets->links()}}
					</ul>
				</td>
			</tr>
	</tfoot>

</table>
@stop
