<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Paystack;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class WalletController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::with('role', 'va', 'beneficiary')->where('id', auth()->id())->first();
        if( $user->hasAnyRole('promoter') )
        {
            // $wallet = ;
            $totalSales = \App\Models\User::where('id', 1)->withSum('totalSales', 'amount_paid')->first()->total_sales_sum_amount_paid ?? 0;
            $monthlySales = \App\Models\User::where('id', 1)
                            ->withSum([
                                'totalSales as total_sales_sum_amount_paid' => function ($query) {
                                    $query->whereMonth('sales.created_at', Carbon::now()->month)
                                        ->whereYear('sales.created_at', Carbon::now()->year);
                                }
                            ], 'amount_paid')
                            ->first()?->total_sales_sum_amount_paid ?? 0;
            return view('dashboard.promoter.wallet.index', [
                            'user' => $user, 
                            'totalSales' =>  $totalSales,
                            'monthlySales' => $monthlySales
                        ]);
        }
        return view('dashboard.user.wallet.index', ['user' => $user]);
    }

    public function fundWallet(Request $request):JsonResponse
    {
        $paystack = new Paystack();
        $transaction = $paystack->ConfirmPaymentWebhook($request->data->reference, $request->data->customer->email);
        event(new \App\Events\SuccessfulWalletFunding($transaction));
        return response()->json([
            'status' => true,
            'message' => "Webhook succesfully processed"
        ]);
    }

    public function generateCheckoutUrl(Request $request):JsonResponse
    {
        $paystack = new Paystack();
        $user = \App\Models\User::find(auth()->id());
        $checkoutUrl = $paystack->GeneratePaymentUrl($user, $request->amount);
        return response()->json([
            'status' => true,
            'data' => $checkoutUrl
        ]);
    }

}
