<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Ticket;
use App\TicketMsg;

use Carbon\Carbon;


class TicketController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index(Request $request){

		if (Auth::user()->is_admin){
			return $this->listForAdmin($request);
		} else {			
			return $this->listForUser();
		}
		
	}

	public function listForUser(){

		$tickets = (new Ticket)
	    ->newQuery()->where("user_id", Auth::user()->id)->with("user")->
	    orderBy('updated_at','desc')->paginate(20);

	    $statuses = Ticket::STATUSES;

		return view("tickets.listuser", [
			"tickets"=>$tickets,
			"statuses" => $statuses,
			"filter" => 666,

		]);	

	} 

	public function listForAdmin(Request $request){
		$filter=0;
		if (isset($request->filter)){
			$filter = $request->filter;
			if ($filter <=4 ){ //Открытые статусы
				$tickets = (new Ticket)
			    ->newQuery()->whereNull("closed")->where('status',$filter)->with("user")->
			    orderBy('updated_at','desc')->paginate(20);

			} else  if ($filter == 5){ //закрытые тикеты

				$tickets = (new Ticket)
			    ->newQuery()->whereNotNull("closed")->with("user")->
			    orderBy('updated_at','desc')->paginate(20);

			} else if ($filter == 6){ 
				//в статусе ожидает ответа в теч месяца
				$month_ago = Carbon::now()->subMonth(1);
				$tickets = (new Ticket)
			    ->newQuery()->whereNull("closed")->where('status',4)->where("updated_at","<",$month_ago)->with("user")->
			    orderBy('updated_at','desc')->paginate(20);
			}

		} else { //полный список без "закрытых"
			$tickets = (new Ticket)
		    ->newQuery()->whereNull("closed")->with("user")->
		    orderBy('updated_at','desc')->paginate(20);
		}
		
		

	    $statuses = Ticket::STATUSES;

		return view("tickets.listuser", [
			"tickets"=>$tickets,
			"statuses" => $statuses,
			"filter" => $filter
		]);

	} 
	

	public function show( $ticket_id ){

		$ticket = Ticket::select('id','status','title','msg','updated_at','user_id')->where('id',$ticket_id)->with('user')->first();

		$this->checkPrem($ticket);

		if ($ticket && Auth::user()->is_admin && $ticket->status < 3) {
			$this->changeStatus($ticket->id, 3); // статус - прочитан
		}

		$msges =  TicketMsg::select('id','user_id','msg_text','updated_at')->where('ticket_id', $ticket_id)->with("user")->get();

		return view("tickets.ticket", [
			"ticket"=>$ticket,
			"msges" => $msges,			
		]);

	}

	public function create (){

		return view("tickets.ticketCreate");
	}

	public function store(Request $request){

		$request->validate([
		    'title' => 'required|max:255',
		    'msg' => 'required'
		]);

		$ticket = new Ticket();
		$ticket->user_id = Auth::user()->id;
		$ticket->title = $request->title;
		$ticket->msg = $request->msg;
		$ticket->status = 1;
		$ticket->save();

		return redirect()->route('ticket', [$ticket->id]);

	}

	public function saveMsg(Request $request, $ticket_id, $status = null ){
		
		$ticket = Ticket::where('id',$ticket_id)->first();
		
		$this->checkPrem($ticket);

		$request->validate([
		    'msg_text' => 'required'
		]);

		$msg = new TicketMsg();
		$msg->user_id = Auth::user()->id;
		$msg->ticket_id = $ticket_id;
		$msg->msg_text = $request->msg_text;

		$msg->save();

		if (Auth::user()->is_admin) {
			$this->changeStatus($ticket_id, 4); // ожидает ответа польз
		} else {
			$this->changeStatus($ticket_id, 2); // в процессе
		}

		return redirect()->route('ticket',[$ticket_id]);

	}

	public function changeStatus ($ticket_id, $new_status ){

		$ticket = Ticket::find($ticket_id);
		if ($ticket){			
			$ticket->status = $new_status;
			$ticket->save();

		} else {
			return "Ошибка изменения статуса";
		}

	}

	public function closeTicket($ticket_id){
		$ticket = Ticket::find($ticket_id);

		$this->checkPrem($ticket);

		$ticket->status=5;
		$ticket->closed=1;
		$ticket->save();

		return redirect()->route('home');

	}

	protected function checkPrem(Ticket $ticket){
		if ($ticket && $ticket->user_id == Auth::user()->id || 
			Auth::user()->is_admin){
				return true;
			} else {
				abort(403, 'Unauthorized action.');
			}	
	}


    
}
