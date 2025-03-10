<?php
declare(strict_types = 1);
namespace App\DTO\Paystack;

final class CheckoutUrl
{
    public function __construct(
        public readonly string $checkoutUrl,
        public readonly string $paymentReference,
        public readonly string $access_code,
        public readonly \App\Models\User $user
    )
    {}
}