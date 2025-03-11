<?php
declare(strict_types = 1);
namespace App\Services;
use App\Contracts\PaymentProvider;
use Illuminate\Support\Facades\Http;

use App\DTO\Paystack\GeneratedAccount;
use App\DTO\Paystack\CreateCustomer;
use App\DTO\Paystack\CheckoutUrl;
use App\Models\User;

class Paystack extends PaymentProvider
{
    public function __construct()
    {   
        parent::__construct('paystack');
    }

    public function CreateCustomer(User $user):CreateCustomer
    {
        try {
            $names = explode(' ', $user->name);
            $request = Http::secretKeyRequest(config('paystack.url.create_customer'), [
                'email' => $user->email,
                'first_name' => trim($names[0]),
                'last_name' => trim($names[1]),
            ]);
            $response = $request->object();
            if ( $request->failed() || !$response->status) {
                throw new \Exception("Error Processing Request", 1);  
            }
            return new CreateCustomer( $response->data->id, $user, $this->provider );
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 1);
        }
    }   
    
    public function AssignVirtualAccount(User $user, int $customer_id):GeneratedAccount
    {
        try {
            $request = Http::secretKeyRequest(config('paystack.url.assign_virtual_account'), [
                'customer' => $customer_id,
            ]);
            $response = $request->object();
            if ( $request->failed() || !$response->status) {
                throw new \Exception("Unable to assign Virtual account", 1);  
            }
            return new GeneratedAccount( 
                $response->data->account_name, 
                $response->data->account_number,
                $response->data->bank->name, 
                $user,
                $this->provider 
            );
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 1);
        }
    }

    public function GeneratePaymentUrl(User $user, int $amount): CheckoutUrl
    {
        try {
            $dateTime = new \DateTime();
            $request = Http::secretKeyRequest(config('paystack.url.generate_payment_url'), [
                'email' => $user->email,
                'amount' => ( float ) $amount * 100,
                'reference' => $dateTime->getTimestamp()
            ]);
            $response = $request->object();
            if ( $request->failed() || !$response->status) {
                throw new \Exception("Unable to generate payment url", 1);  
            }
            return new CheckoutUrl(
                $response->data->authorization_url, 
                $response->data->reference,
                $response->data->access_code,
                $user
            );
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 1);
        }

    }

    public function ConfirmPaymentWebhook(string $transaction_reference, string $email): \App\DTO\WalletFundingConfirmation
    {
        try {
            $url = config('paystack.url.confirm_transaction') . '/'. $transaction_reference;
            $request = Http::secretKeyGetRequest( $url, []);
            $response = $request->object();
            if ( $request->failed() || $response->data->status != 'success' || !$response->status) {
                throw new \Exception("Unable to confirm the status of the transaction", 1);  
            }
            return new \App\DTO\WalletFundingConfirmation(
                $transaction_reference,
                ( float ) $response->data->amount / 100,
                $email
            );
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 1);
        }
    }

    public static function GetBanks($cursor = null)
    {
        try {
            $request = Http::secretKeyGetRequest( config('paystack.url.get_banks'), [
                'country' => 'nigeria',
                'use_cursor' => true,
                'perPage' => 100,
                // 'pay_with_bank' => true,
                'next' => $cursor
            ]);
            $response = $request->object();
            if ( $request->failed() || !$response->status) {
                throw new \Exception("Unable to confirm the status of the transaction", 1);  
            }
            return $response;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage(), 1);
        }
    }
}