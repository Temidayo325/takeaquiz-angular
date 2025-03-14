<?php

namespace App\Listeners\Sales;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreditOrganizer
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(\App\Events\TicketSold $sale): void
    {
        // Add the price of the ticket To the Organizer's account
        $event_organizer = \App\Models\Event::with('user')->where('id', $sale->ticket->event_id)->first();
        $virtualWallet = \App\Models\VirtualAccount::select('balance')->where('user_id', $event_organizer->user->id)->first();
        $virtualWallet->balance = $virtualWallet->balance - $sale->ticket->price;
        $virtualWallet->save();
        $walletAcitivy = ( new \App\Actions\Wallet\Activity() )($event_organizer->user, $sale->ticket->price, 'Credit');
    }
}
