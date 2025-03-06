<?php
declare(strict_types = 1);
namespace App\Services;
use App\Contracts\PaymentProvider;
use Illuminate\Support\Facades\Http;

use App\DTO\Paystack\GeneratedAccount;
use App\DTO\Paystack\CreateCustomer;

class Paystack extends PaymentProvider
{
    public function __construct()
    {   
        parent::__construct('paystack');
    }

    public function CreateCustomer(\App\Models\User $user):CreateCustomer
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
    
    public function AssignVirtualAccount(\App\Models\User $user, int $customer_id):GeneratedAccount
    {
        try {
            $request = Http::secretKeyRequest(config('paystack.url.assign_virtual_account'), [
                'customer' => $customer_id,
            ]);
            $response = $request->object();
            if ( $request->failed() || !$response->status) {
                throw new \Exception("Error Processing Request", 1);  
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
}