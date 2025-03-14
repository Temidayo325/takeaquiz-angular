<?php

namespace App\Listeners\Sales;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewSales
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
    public function handle(\App\Events\TicketSold $sales): void
    {
        // Create a new sales record
        $sale = ( new \App\Actions\Sale\CreateSale() )($sales->ticket, "Success");
    }
}
