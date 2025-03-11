<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class WalletController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::with('role', 'va')->where('id', auth()->id())->first();
        if($user->hasAnyRole('promoter'))
        {
            return view('dashboard.promoter.wallet.index', ['user' => $user]);
        }
        return view('dashboard.user.wallet.index', ['user' => $user]);
    }

    public function fundWallet(Request $request)
    {
        $paystack = new \App\Services\Paystack();
        $transaction = $paystack->ConfirmPaymentWebhook($request->data->reference, $request->data->customer->email);
        event(new \App\Events\SuccessfulWalletFunding($transaction));
    }

    public function findBank($bank_name)
    {
        $users = Search::add(\App\Models\Bank::class, ['name', 'slug'])
					    ->beginWithWildcard()
					    ->endWithWildcard(true)
					    ->orderByRelevance()
					    ->search($bank_name);
    	return response()->json([
    		'error' => false,
    		'errorMessage' => 'Bank search results returned successfully',
    		'data' => $users
    	]);
    }

    public function createBeneficiary(Request $request)
    {
        $paystack_benefiary = \App\Services\PaystackCustomerSettlement::createBeneficiary( $request->name,  $request->number, $request->bank_code) ;
        $beneficiary = ( new \App\Actions\Wallet\CreateBeneficiary() )($paystack_benefiary);
        return response()->json([
            'error' => false,
            'errorMessage' => "Beneficiary created",
            'beneficiary' => $beneficiary
        ]);
    }
}
