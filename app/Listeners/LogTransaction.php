<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\SuccessfulWalletFunding;

class LogTransaction
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
    public function handle(SuccessfulWalletFunding $walletFunding): void
    {
        //Log the transaction
        $transaction_details = $walletFunding->transaction_details;
        $newTransaction = ( new \App\Actions\Wallet\Fund() )( $transaction_details );
    }
}
