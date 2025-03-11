<?php
declare(strict_types = 1);

namespace App\DTO\Paystack;

class Beneficiary
{
    public function __construct(
        public readonly string $account_name,
        public readonly string $account_number,
        public readonly string $recipient_code,
        public readonly int $id,
        public readonly string $bank_code,
        public readonly string $bank_name
    ){}
}