<?php
declare(strict_types = 1);
namespace App\DTO\Paystack;

use App\Models\User;

final class GeneratedAccount
{
    public function __construct(
        public readonly string $account_name,
        public readonly  string $account_number,
        public readonly string $bank,
        public readonly User $user,
        public readonly string $provider
    ) {}
}