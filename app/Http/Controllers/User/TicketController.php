<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Mail;
use App\Mail\BoughtTicket;

class TicketController extends Controller
{
    public function index()
    {
    	$events = Sale::with('ticket', 'event.user')->latest()->where('user_id', auth()->id())->get();
        $user = \App\Models\User::with('role', 'va')->where('id', auth()->id())->first();
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
        $user = \App\Models\User::with('va', 'role')->where('id', auth()->id())->first();
        return view("dashboard.user.ticket.checkout", ['user' => $user, 'ticket' => $ticket]);
    }

    public function purchase()
    {
        // Register the ticket against the user
        // return payment details
        // return redirect()->intended(route('user.dashboard.tickets', absolute: false));
    }

    public function initiatePayment(Request $request)
    {
        $ticket = \App\Models\Ticket::with('event')->where('id',$request->ticket_id)->first();
        try {
            $saleExists = \App\Models\Sale::where('ticket_id', $request->ticket_id)->where('user_id', auth()->id())->first();
            if ($saleExists != null) {
                throw new \Exception("You have purchased the ticket previously");
            }

            if ( $ticket->available_seat < 1) {
                throw new \Exception("Ooops!! We've sold out");
            }

            if ($ticket->access_type == "Purchase" || $ticket->price > 0) {
                $balance = \App\Models\VirtualAccount::select('balance')->where('user_id', auth()->id())->first()->balance;
                if($balance < $ticket->price)
                {
                    throw new \Exception("Insufficient wallet balance, top up your wallet to continue", 1);
                }
                event(new \App\Events\TicketSold($ticket, auth()->user()));
                Mail::to($ticket)->send(new BoughtTicket($ticket, $ticket->event, auth()->user()));
            }
            
            if( $ticket->access_type == "Free" )
            {
                event(new \App\Events\TicketSold($ticket, auth()->user()));
                Mail::to($ticket)->send(new BoughtTicket($ticket, $ticket->event, auth()->user()));
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
