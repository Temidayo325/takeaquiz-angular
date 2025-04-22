<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserBoughtTicket;
use App\Services\Paystack;
use Illuminate\Support\Facades\Session;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

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

    public function Checkout($ticket_name)
    {
        $ticket_name = preg_replace('/-/', ' ', $ticket_name);
        $ticket = Search::add(\App\Models\Ticket::with('event.user')->where('status', 'PUBLISHED'), ['name'])
					    ->beginWithWildcard(true)
					    ->endWithWildcard(true)
					    ->orderByRelevance()
					    ->search($ticket_name);
        // $ticket = \App\Models\Ticket::with('event.user')->where('name', 'LIKE', '%'.$ticket_name.'%')->first();
        if(auth()->user() != null)
        {
            $user = \App\Models\User::with('va', 'role')->where('id', auth()->id())->first();
            return view("dashboard.user.ticket.checkout", ['user' => $user, 'ticket' => $ticket[0]]);
        }
        return view("guest.checkout", ['ticket' => $ticket[0]]);
    }

    public function purchase()
    {
        // Register the ticket against the user
        // return payment details
        // return redirect()->intended(route('user.dashboard.tickets', absolute: false));
    }

    public function initiatePayment(Request $request)
    {
        $ticket = \App\Models\Ticket::with('event.user')->where('id',$request->ticket_id)->first();

        try {
            $saleExists = \App\Models\Sale::where('ticket_id', $request->ticket_id)->where('user_id', auth()->id())->first();
            if ($saleExists != null) {
                throw new \Exception("You have purchased the ticket previously");
            }

            if ( $ticket->available_seat < 1) {
                throw new \Exception("Ooops!! We've sold out");
            }

            if ($ticket->access_type == "Purchase" || $ticket->price > 0) 
            {
                $balance = \App\Models\VirtualAccount::select('balance')->where('user_id', auth()->id())->first()->balance;
                if($balance < $ticket->price)
                {
                    throw new \Exception("Insufficient wallet balance, top up your wallet to continue", 1);
                }
                event(new \App\Events\TicketSold($ticket, auth()->user()));
                Mail::to(auth()->user()->email)->send(new UserBoughtTicket($ticket, $ticket->event, auth()->user()));
            }
            
            if( $ticket->access_type == "Free" )
            {
                event(new \App\Events\TicketSold($ticket, auth()->user()));
                Mail::to(auth()->user()->email)->send(new UserBoughtTicket($ticket, $ticket->event, auth()->user()));
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

    public function guestPayment(Request $request)
    {
        try {
            $ticket = \App\Models\Ticket::with('event.user')->where('id',$request->ticket_id)->first();
            // Create the database reference
            $guest = \App\Models\Guest::query()->where('email', $request->user['email'])->latest()->first();
            if($guest == null)
            {
                $guest = \App\Models\Guest::create([
                    'name' => $request->user['name'],
                    'email' => $request->user['email'],
                    'nickname' => $request->user['nickname'],
                    'phone' => $request->user['phone']
                ]);
            }
            // generate the payment link
            $callback_url = secure_url('/confirm-ticket-purchase');
            $paystack = new Paystack();
            $payment_link = $paystack->GeneratePaymentUrl($guest, $ticket->price, $callback_url);
            $guest->payment_reference = $payment_link->paymentReference;
            $guest->save();
            Session::put($guest->email.'_ticket_id', $ticket->id);

            // Create a Transaction
            $date = new \DateTime();
            \App\Models\Transaction::create([
                'reference' => $payment_link->paymentReference,
                'timestamp' => $date->getTimestamp(),
                'amount' => $ticket->price,
                'balance_before_transaction' => 0,
                'balance_after_transaction' => 0,
                'status' =>  'PENDING',
                'type' =>  'CREDIT',
                'user_id' => $payment_link->paymentReference
            ]);

            return response()->json([
                'error' => false,
                'errorMessage' => "Succesfully generate a payment link",
                'callback_url' => $callback_url,
                'info' => $payment_link
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function confirmGuestPayment(Request $request )
    {
        try {
            $guest = \App\Models\Guest::query()->where('payment_reference', $request->reference)->first();
            $ticket_id = Session::get($guest->email.'_ticket_id');
            $ticket = \App\Models\Ticket::with('event.user')->where('id', $ticket_id)->first();

            $sales = \App\Models\Sale::query()->where('user_id', $guest->payment_reference)->first();
            if($sales != null)
            {
                return view('guest.purchase-status', [
                    'ticket' => $ticket,
                    'error' => false, 
                    'message' => "Ticket purchase succesful!! A copy of your receipt has been sent to your email"
                ]);
            }

            //Confirm the payment
            $paystack = new Paystack();
            $payment = $paystack->ConfirmPaymentWebhook($request->reference, $guest->email);
            if($payment->amount < $ticket->price)
            {
                throw new \Exception("Amount paid is less than the ticket price", 1);
            }
            // Update Transaction status
            $transaction = \App\Models\Transaction::query()->where('user_id', $guest->payment_reference)->where('status', 'PENDING')->first();
            $transaction->status = 'PAID';
            $transaction->save();
            
            //Credit the Promoter
            $virtualWallet = \App\Models\VirtualAccount::where('user_id', $ticket->event->user->id)
            ->lockForUpdate()
            ->first();
            $virtualWallet->increment('balance', $payment->amount);
            // Create a sales record
            $sale = ( new \App\Actions\Sale\CreateSale() )($ticket, "Success", $guest->payment_reference);
            $wallet_activity = ( new \App\Actions\Wallet\Activity() )($ticket->event->user, $ticket->price , "Credit");
            // Update the ticket quantity
            $ticket->decrement('available_seat', 1);
            Mail::to($guest->email)->send(new UserBoughtTicket($ticket, $ticket->event, $guest));
            return view('guest.purchase-status', [
                'ticket' => $ticket,
                'error' => false, 
                'message' => "Ticket purchase succesful!! A copy of your receipt has been sent to your email"
            ]);
        } catch (\Throwable $th) {
            return view('guest.purchase-status', [
                'ticket' => $ticket,
                'error' => true, 
                'message' => $th->getMessage()
            ]);
        }
    }
}
