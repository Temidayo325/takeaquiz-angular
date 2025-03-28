<?php
declare(strict_types = 1);
namespace App\Contracts;

interface PaymentGateway 
{
    public function GeneratePaymentUrl(\App\Models\User|\App\Models\Guest $user, int $amount, ?string $callback_url = null): \App\DTO\Paystack\CheckoutUrl;
    public function ConfirmPaymentWebhook(string $transaction_reference, string $email);
}
