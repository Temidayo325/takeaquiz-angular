<?php

return [
    'keys' => [
        'public' => env("PAYSTACK_PUBLIC_KEY"),
        'secret' => env("PAYSTACK_SECRET_KEY")
    ],
    'url' => [
        'assign_virtual_account' => env('PAYSTACK_ASSIGN_VIRTUAL_ACCOUNT'),
        'create_customer' => env("PAYSTACK_CREATE_CUSTOMER"),
        'generate_payment_url' => env("PAYSTACK_GENERATE_PAYMENT_URL"),
        'confirm_transaction' => env("PAYSTACK_CONFIRM_TRANSACTION"),
        'create_beneficiary' => env("PAYSTACK_CREATE_ORGANIZER_SETTLEMENT_ACCOUNT"),
        'get_banks' => env("PAYSTACK_GET_BANKS")
    ]
];
