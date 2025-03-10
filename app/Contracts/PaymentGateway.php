<?php
declare(strict_types = 1);
namespace App\Contracts;

interface PaymentGateway 
{
    public function GeneratePaymentUrl(\App\Models\User $user, int $amount): \App\DTO\Paystack\CheckoutUrl;
    public function ConfirmPaymentWebhook(string $transaction_reference, string $email);
}
