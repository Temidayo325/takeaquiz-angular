<?php
declare(strict_types = 1);
namespace App\DTO;


final class WalletFundingConfirmation
{
    public function __construct(
        public readonly string $transaction_reference,
        public readonly float $amount,
        public readonly string $email,
    ) {}
}