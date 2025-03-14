<?php

namespace App\Http\Controllers\Promoter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use ProtoneMedia\LaravelCrossEloquentSearch\Search;

class BeneficiaryController extends Controller
{
    
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
