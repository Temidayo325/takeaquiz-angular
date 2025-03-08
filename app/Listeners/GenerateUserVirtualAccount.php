<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Services\Paystack;

class GenerateUserVirtualAccount
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
    public function handle(UserLoggedIn $event): void
    {
        $user = $event->user;
        if ( $user->va->account_number == NULL ) {
            $paystack  = new Paystack();
            $vitualAccount = $paystack->AssignVirtualAccount($user, $user->va->customer_id);
            $user->va->update([
                'account_name' => $vitualAccount->account_name,
                'account_number' => $vitualAccount->account_number,
                'bank' => $vitualAccount->bank
            ]);
        }
    }
}
