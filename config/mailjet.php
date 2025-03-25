<?php

return [
    'keys' => [
        'public' => env("MAILJET_PUBLIC"),
        'secret' => env("MAILJET_SECRET_KEY")
    ],
    'url' => [
        'send_template' => env("MAILJET_SEND_TEMPLATE"),
    ]
];
