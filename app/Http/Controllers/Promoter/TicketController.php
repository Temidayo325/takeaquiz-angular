<?php

namespace App\Http\Controllers\Promoter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
    	$events = \App\Models\Event::with(['tickets.attendance.user' => function ($query){
                $query->select('id','nickname', 'email', 'updated_at'); 
            }])->select('id', 'user_id', 'name', 'state', 'starting_time', 'event_date', 'location', 'flier', 'isPremium', 'promotional_copy')
    			->where('user_id', auth()->id())
    			->latest()
    			->orderBy('id')
    			->cursorPaginate(5);
        $user = \App\Models\User::with('role', 'va')->where('id', auth()->id())->first();
    	return view("dashboard.promoter.ticket.index", ['events' => $events, 'user' => $user]);
    }

    public function create()
    {
    	$events = \App\Models\Event::with('tickets')
                            ->where('user_id', auth()->id())
    						->where('event_date', '>=',\Carbon\Carbon::now())
    						->latest()
			    			->orderBy('id')
			    			->cursorPaginate(5);
        $user = \App\Models\User::with('role', 'va')->where('id', auth()->id())->first();
    	return view("dashboard.promoter.ticket.create", [ 'events' => $events, 'user' => $user ]);
    }

    public function store(\App\Http\Requests\Ticket\CreateTicketRequest $request)
    {
    	try {
			$ticket = \App\Models\Ticket::where('name', $request->name)->where('price', $request->price)->first();
    		if($ticket == null)
			{
				$ticket = \App\Models\Ticket::create([
    				'event_id' => $request->event_id,
			    	'price' => $request->price,
			    	'total_seat' => $request->total_seat,
			    	'available_seat' => $request->total_seat,
                    'name' => $request->name,
			    	'type' => $request->ticket_type,
			    	'type_copy' => $request->type_copy,
			        'access_type' => $request->access_type
    			]);
			}
    		return response()->json([
	    		'error' => false,
	    		'errorMessage' => 'Ticket succesfully created',
	    		'ticket' => $ticket
	    	]);
    	} catch (\Exception $e) {
    		return response()->json([
	    		'error' => true,
	    		'errorMessage' => $e->getMessage()
	    	]);
    	}
    	
    }

    public function delete(Request $request)
    {
    	$ticket = \App\Models\Ticket::find($request->id);
    	$ticket->delete();
    	$events = \App\Models\Event::with('tickets')
    			->select('id', 'user_id', 'name', 'state', 'starting_time', 'event_date')
    			->where('user_id', auth()->id())
    			->latest()
    			->orderBy('id')
    			->cursorPaginate(5);
    	return response()->json([
    		'error' => false,
    		'errorMessage' => 'Ticket succesfully deleted',
    		'events' => $events
    	]);
    }

}
