<?php

namespace App\Listeners\Sales;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DebitUser
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
        // Remove the price of the ticket from the User (Customer)
        $virtualWallet = \App\Models\VirtualAccount::where('user_id', $sale->user->id)
            ->lockForUpdate()
            ->first();
        $virtualWallet->decrement('balance', $sale->ticket->price);
        // Create a walletActivity
        $walletAcitivy = ( new \App\Actions\Wallet\Activity() )($sale->user, $sale->ticket->price, 'Debit');
    }
}
