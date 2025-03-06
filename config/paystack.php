<?php

return [
    'keys' => [
        'public' => env("PAYSTACK_PUBLIC_KEY"),
        'secret' => env("PAYSTACK_SECRET_KEY")
    ],
    'url' => [
        'assign_virtual_account' => env('PAYSTACK_ASSIGN_VIRTUAL_ACCOUNT'),
        'create_customer' => env("PAYSTACK_CREATE_CUSTOMER")
    ]
];
