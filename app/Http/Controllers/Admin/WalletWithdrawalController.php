<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class WalletWithdrawalController extends Controller
{
    public function index()
    {
        $user = \App\Models\User::with('va')->where('id', auth()->id())->first();
        $notification = \App\Models\Notification::with('user.va')
                    ->where('role', 'withdrawal')
                    ->where('status', false)
                    ->get();

        return view('dashboard.admin.wallet.notification', [
            'user' => $user,
            'notification' => $notification
        ]);
    }

    public function approve(Request $request)
    {}

    public function initializeWithdrawal(Request $request)
    {
        try {
            $notification = \App\Models\Notification::select('user_id', 'summary')->where('id', $request->notification_id)->first();
            $beneficiary = \App\Models\Beneficiary::query()->where('user_id', $notification->user_id)->first();
            $transfer_code = \App\Services\PaystackCustomerSettlement::initializeBeneficiaryPayment($beneficiary, (int) $notification->summary);

            Cache::put('otp_'.$notification->user_id, $transfer_code, $seconds = 1500);
            return response()->json([
                'error' => false,
                'errorMessage' => "Complete request with OTP",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'errorMessage' => $th->getMessage()
            ]);
        }
        
    }

    public function completeWithdrawal(Request $request)
    {
        try {
            $completeTransaction = \App\Services\PaystackCustomerSettlement::finalizeBeneficiaryPayment($request->user_id, (int) $request->otp);
            // Update User wallet
            // Remove the price of the ticket from the User (Customer)
            $virtualWallet = \App\Models\VirtualAccount::with('user')->where('user_id', $request->user_id)
            ->lockForUpdate()
            ->first();
            $virtualWallet->decrement('balance', $request->amount);
            // Create a walletActivity
            $walletAcitivy = ( new \App\Actions\Wallet\Activity() )($virtualWallet->user, (int) $request->amount, 'Debit');
            return response()->json([
                'error' => false,
                'errorMessage' => "Withdrawal completed",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'errorMessage' => $th->getMessage()
            ]);
        }
    }
}
