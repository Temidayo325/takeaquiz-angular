<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::with('role', 'va')->where('id', auth()->id())->first();
        return view('dashboard.user.wallet.index', ['user' => $user]);
    }

    public function fundWallet(Request $request)
    {
        $paystack = new \App\Services\Paystack();
        $transaction = $paystack->ConfirmPaymentWebhook($request->data->reference, $request->data->customer->email);
        event(new \App\Events\SuccessfulWalletFunding($transaction));
    }
}
