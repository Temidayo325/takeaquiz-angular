<?php
declare(strict_types = 1);
namespace App\Actions\User;

use App\DTO\Paystack\CreateCustomer as NewCustomer;

class CreateCustomer
{
    public function __invoke(NewCustomer $customer)
    {
        $virtualAccount = new \App\Models\VirtualAccount([
            'customer_id' => $customer->paystack_customer_id,
            'provider' => $customer->provider
        ]);

        $customer->user->va()->save($virtualAccount);
    }
}