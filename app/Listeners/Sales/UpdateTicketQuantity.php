<?php

namespace App\Listeners\Sales;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateTicketQuantity
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
        $sale->ticket->available_seat = (int) $sale->ticket->available_seat - 1;
        $sale->ticket->save(); 
    }
}
