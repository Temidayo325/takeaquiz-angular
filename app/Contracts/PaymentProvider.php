<?php
declare(strict_types = 1);

namespace App\Contracts;

abstract class PaymentProvider implements PaymentGateway
{

    public function __construct(protected readonly string $provider)
    {}

    public function getProvider(): string
    {
        return $this->provider;
    }
}