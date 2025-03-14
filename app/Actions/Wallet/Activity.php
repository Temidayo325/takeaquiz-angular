<?php
declare(strict_types = 1);
namespace App\Actions\Wallet;
use App\Models\WalletActivity;

final class Activity
{
    public function __invoke(\App\models\User $user, int $amount, string $type)
	{
        $balance = \App\models\VirtualAccount::where('user_id', $user->id)->first()->balance;
        $wallet_activity = WalletActivity::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => $type,
            'balance_before' => $balance,
            'balance_after' => ( $type = 'Credit' ) ? $amount + $balance : $balance - $amount,
        ]);
	}
}