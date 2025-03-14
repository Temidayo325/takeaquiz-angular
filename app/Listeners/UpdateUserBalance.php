<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUserBalance
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
    public function handle(\App\Events\SuccessfulWalletFunding $walletFunding): void
    {
        //Log the transaction
        $transaction_details = $walletFunding->transaction_details;
        $user = \App\Models\User::with('va')->where('email', $transaction_details->email)->first();
        $user->va->update([
            'balance' => $user->va->balance + ( $transaction_details->amount / 100)
        ]);
    }
}
