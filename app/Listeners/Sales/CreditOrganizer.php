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
        $virtualWallet = \App\Models\VirtualAccount::where('user_id', $event_organizer->user->id)
            ->lockForUpdate()
            ->first();
        $virtualWallet->increment('balance', $sale->ticket->price);
        $walletAcitivy = ( new \App\Actions\Wallet\Activity() )($event_organizer->user, $sale->ticket->price, 'Credit');
    }
}
