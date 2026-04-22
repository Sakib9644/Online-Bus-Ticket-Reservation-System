<?php

declare(strict_types=1);

// config for Raziul/Sslcommerz

return [
    /**
     * Enable/Disable Sandbox mode
     */
    'sandbox' => env('SSLC_SANDBOX', true),

    /**
     * The API credentials given from SSLCommerz
     */
    'store' => [
        'id' => env('SSLCZ_STORE_ID'),
        'password' => env('SSLCZ_STORE_PASSWORD'),
        'currency' => env('SSLC_STORE_CURRENCY', 'BDT'),
    ],

    /**
     * Route names for success/failure/cancel
     */
    'route' => [
        'success' => 'sslc.success',
        'failure' => 'sslc.failure',
        'cancel' => 'sslc.cancel',
        'ipn' => 'sslc.ipn',
    ],

    /**
     * Product profile required from SSLC
     * By default it is "general"
     *
     * AVAILABLE PROFILES
     *  general
     *  physical-goods
     *  non-physical-goods
     *  airline-tickets
     *  travel-vertical
     *  telecom-vertical
     */
    'product_profile' => 'general',
];
