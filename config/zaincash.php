<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults ZainCash
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication with ZainCash and password
    | reset options for your application. You may change these defaults
    | as required, but they're a good start for most applications.
    |
    */
 
    'defaults' => [
        'msdin_zain_cash' => env('ZAINCASH_DEFAULT_MSDIN', '9647835077893'),
        'secret_zain_cash' => env('ZAINCASH_DEFAULT_SECRET', '$2y$10$hBbAZo2GfSSvyqAyV2SaqOfYewgYpfR1O19gIh4SqyGWdmySZYPuS'),
        'merchant_id_zain_cash' => env('ZAINCASH_DEFAULT_MERCHANT_ID', '5ffacf6612b5777c6d44266f'),
        'url_zain_cash' => env('ZAINCASH_DEFAULT_URL', 'https://test.zaincash.iq/transaction/get'),
        'url_init'=>env('ZAINCASH_DEFAULT_URL_INIT', 'https://test.zaincash.iq/transaction/init'),
        'url_pay'=>env('ZAINCASH_DEFAULT_URL_PAY', 'https://test.zaincash.iq/transaction/pay?id=')
    ], 

    '3abee' => [
        'msdin_zain_cash' => env('ZAINCASH_DEFAULT_MSDIN', '9647835077893'),
        'secret_zain_cash' => env('ZAINCASH_DEFAULT_SECRET', '$2y$10$hBbAZo2GfSSvyqAyV2SaqOfYewgYpfR1O19gIh4SqyGWdmySZYPuS'),
        'merchant_id_zain_cash' => env('ZAINCASH_DEFAULT_MERCHANT_ID', '5ffacf6612b5777c6d44266f'),
        'url_zain_cash' => env('ZAINCASH_DEFAULT_URL', 'https://test.zaincash.iq/transaction/get'),
        'url_init'=>env('ZAINCASH_DEFAULT_URL_INIT', 'https://test.zaincash.iq/transaction/init'),
        'url_pay'=>env('ZAINCASH_DEFAULT_URL_PAY', 'https://test.zaincash.iq/transaction/pay?id=')
    ], 
  
  
    /*
    |--------------------------------------------------------------------------
    | Authentication Settings for Gamrje Environment
    |--------------------------------------------------------------------------
    |
    | Here you can define authentication settings specific to the "gamrje"
    | environment for ZainCash integration.
    |
    */
    'gamrje' => [
        'msdin_zain_cash' => env('ZAINCASH_GAMRJE_MSDIN','9647835077893'),
        'secret_zain_cash' => env('ZAINCASH_GAMRJE_SECRET', '$2y$10$hBbAZo2GfSSvyqAyV2SaqOfYewgYpfR1O19gIh4SqyGWdmySZYPuS'),
        'merchant_id_zain_cash' => env('ZAINCASH_GAMRJE_MERCHANT_ID',  '5ffacf6612b5777c6d44266f'),
        'url_zain_cash' => env('ZAINCASH_GAMRJE_URL', 'https://test.zaincash.iq/transaction/get'),
        'url_init'=>env('ZAINCASH_GAMRJE_URL_INIT', 'https://test.zaincash.iq/transaction/init'),
        'url_pay'=>env('ZAINCASH_GAMRJE_URL_PAY', 'https://test.zaincash.iq/transaction/pay?id=')
    ],

];
