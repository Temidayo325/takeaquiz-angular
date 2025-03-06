<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Paystack;

class CreatePaystackCustomer
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
    public function handle(Registered $event): void
    {
        $paystack  = new Paystack();
        $result = $paystack->CreateCustomer($event->user);
        $virtual_account = ( new \App\Actions\User\CreateCustomer() )($result);
    }
}
