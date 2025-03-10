<?php 
declare(strict_types = 1);
namespace App\Actions\Wallet;


use App\Models\Transaction;
/**
 * 
 */
class Fund
{
	
	public function __invoke(\App\DTO\WalletFundingConfirmation $transaction)
	{
        $user = \App\Models\User::with('va')->where('email', $transaction->email)->first();
        $transaction_exists = \App\Models\Transaction::query()->where('reference', $transaction->transaction_reference)->first();
        if( $transaction_exists == null)
        {
            $date = new \DateTime();
            Transaction::create([
                'reference' => $transaction->transaction_reference,
                'timestamp' => $date->getTimestamp(),
                'amount' => $transaction->amount,
                'balance_before_transaction' => $user->va->balance,
                'balance_after_transaction' => $user->va->balance + $transaction->amount,
                'status' =>  'PAID',
                'type' =>  'CREDIT',
                'user_id' => $user->id
            ]);
        }
        
	}
}