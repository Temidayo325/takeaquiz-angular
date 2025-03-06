<?php
declare(strict_types = 1);
namespace App\DTO\Paystack;

use App\Models\User;

final class CreateCustomer
{
    public function __construct(
        public readonly int $paystack_customer_id,
        public readonly User $user ,
        public readonly string $provider
    ) {}
}