<?php
declare(strict_types = 1);
namespace App\Services;
use App\Contracts\PaymentProvider;
use App\DTO\Paystack\CreateCustomer;
use Illuminate\Support\Facades\Http;

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
    
    // public static function AssignVirtualAccount(int $user_id, int $paystack_customer_id)
    // {

    // }
}
