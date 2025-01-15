<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;

class TicketController extends Controller
{
    public function index()
    {
    	$events = Sale::with('ticket', 'event.user')->latest()->where('user_id', auth()->id())->get();
        $user = \App\Models\User::with('role')->where('id', auth()->id())->first();
    	return view("dashboard.user.ticket.all", ['events' => $events, 'user' => $user]);
    }

    public function upcomingEvents()
    {
    	$upcoming_events = Sale::with('ticket', 'event.user')->whereHas('event', function ($query) {
		    $query->where('event_date', '>', now())->where('status', 'Published')->latest();
		})->where('user_id', auth()->id())->limit(5)->get();
        $user = \App\Models\User::with('role')->where('id', auth()->id())->first();
    	return view("dashboard.user.ticket.upcoming", ['user' => $user, 'upcoming_events' => $upcoming_events]);
    }

    public function toCheckout(\App\Http\Requests\Ticket\TicketIdRequest $ticket)
    {
        // Confirm wallet balance
        // return redirect()->intended(route('user.dashboard.ticket.checkout', absolute: false))
                                        // ->with('ticket_id', $ticket->ticket_id);
        session(["ticket_id" => $ticket->ticket_id]); 
        response()->json([
            'error' => false,
            'message' => "Continue to checkout page"
        ]);            
    }

    public function Checkout()
    {
        $ticket_id = (int) session('ticket_id');
        $ticket = \App\Models\Ticket::with('event.user')->where('id', $ticket_id)->first();
        return view("dashboard.user.ticket.checkout", ['user' => auth()->user(), 'ticket' => $ticket]);
    }

    public function purchase()
    {
        // Register the ticket against the user
        // return payment details
        // return redirect()->intended(route('user.dashboard.tickets', absolute: false));
    }

    public function initiatePayment(Request $request)
    {
        $ticket = \App\Models\Ticket::find($request->ticket_id);
        try {
            $saleExists = \App\Models\Sale::where('ticket_id', $request->ticket_id)->where('user_id', auth()->id())->first();
            if ($saleExists != null) {
                throw new \Exception("You have purchased the ticket previously");
            }
            if ($ticket->access_type == "Free") {
                if ($ticket->price > 0) {
                    throw new Exception("We cannot process paid tickets at this time. ")
                }
                $sale = ( new \App\Actions\Sale\CreateSale() )($ticket, 'Success');
                $ticket->available_seat = $ticket->available_seat - 1;
                $ticket->save(); 
            }

            return response()->json([
                'error' => false,
                'message' => "You have succesfully purchased a ticket for the event"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ]);
        }
        
    }
}
