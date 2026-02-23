<?php
// config/shwary.php

return [
    'merchant_id' => env('SHWARY_MERCHANT_ID'),
    'merchant_key' => env('SHWARY_MERCHANT_KEY'),
    'sandbox' => env('SHWARY_SANDBOX', true),
    'timeout' => env('SHWARY_TIMEOUT', 30),
    'callback_url' => env('SHWARY_CALLBACK_URL', 'https://twendeleye.test/shwary/webhook'),
];

