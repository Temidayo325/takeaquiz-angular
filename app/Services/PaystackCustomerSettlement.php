<?php
declare(strict_types = 1);
namespace App\Services;

use Illuminate\Support\Facades\Http;

class PaystackCustomerSettlement
{
    public static function createBeneficiary(string $account_name, int $account_number, $bank_code)
    {
        try {
            $request = Http::secretKeyRequest( config('paystack.url.create_beneficiary'), [
                'type' => 'nuban',
                'account_name' => $account_name,
                'account_number' => $account_number,
                'bank_code' => $bank_code
            ]);
            $response = $request->object();
            if ( $request->failed() || !$response->status) {
                throw new \Exception("Unable to create beneficiary", 1);  
            }
            return new \App\DTO\Paystack\Beneficiary(
                $response->data->details->account_name,
                $response->data->details->account_number,
                $response->data->recipient_code,
                $response->data->id,
                $response->data->details->bank_code,
                $response->data->details->bank_name,
            );
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 1);
        }
    }

    public static function initializeBeneficiaryPayment(\App\Models\Beneficiary $beneficiary, int $amount)
    {
        try {
            $request = Http::secretKeyRequest( config('paystack.url.initiate_beneficiary_payment'), [
                'source' => 'balance',
                'amount' => $amount * 100,
                'recipient' => $beneficiary->recipient_code,
                'currency' => "NGN",
                'reason' => "Payout from their ticket sales"
            ]);
            $response = $request->object();
            if ( $request->failed() || !$response->status) {
                throw new \Exception("Unable to create beneficiary", 1);  
            }
            return $response;
            // return new \App\DTO\Paystack\Beneficiary(
            //     $response->data->details->account_name,
            //     $response->data->details->account_number,
            //     $response->data->recipient_code,
            //     $response->data->id,
            //     $response->data->details->bank_code,
            //     $response->data->details->bank_name,
            // );
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 1);
        }
    }

    public static function finalizeBeneficiaryPayment(string $transfer_code, int $otp)
    {
        try {
            $request = Http::secretKeyRequest( config('paystack.url.initiate_beneficiary_payment'), [
                'transfer_code' => $transfer_code,
                'otp' => $otp
            ]);

            $response = $request->object();
            if ( $request->failed() || !$response->status) {
                throw new \Exception("Unable to create beneficiary", 1);  
            }
            return $response;
            // return new \App\DTO\Paystack\Beneficiary(
            //     $response->data->details->account_name,
            //     $response->data->details->account_number,
            //     $response->data->recipient_code,
            //     $response->data->id,
            //     $response->data->details->bank_code,
            //     $response->data->details->bank_name,
            // );
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 1);
        }
    }
}
