<?php

namespace App\Http\Controllers\Promoter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
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
        $paystack_benefiary = \App\Services\PaystackCustomerSettlement::createBeneficiary( $request->account_name,  $request->account_number, $request->bank_code) ;
        $beneficiary = ( new \App\Actions\Wallet\CreateBeneficiary() )($paystack_benefiary);
        return response()->json([
            'error' => false,
            'errorMessage' => "Beneficiary created",
            'beneficiary' => $beneficiary
        ]);
    }

    public function initiateWthdraw(Request $request)
    {   
        try {
            $user = \App\Models\User::with('va', 'beneficiary')->where('id', auth()->id())->first();
            if( $user->va->balance < $request->amount )
            {
                throw new \Exception("You cannot withdraw above your balance");
            }
            if($user->beneficiary == null)
            {
                throw new \Exception("Kindly set up your receiving account before proceeding to make a withdrawal request");
            }

            \App\Models\Notification::create([
                'summary' => $request->amount,
                'user_id' => auth()->id(),
                'role' => 'withdrawal'
            ]); 
            return response()->json([
                'error' => true,
                'errorMessage' => 'Withdrawal Request successfully made' 
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => false,
                'errorMessage' => $th->getMessage()
            ]);
        }
    }
}
