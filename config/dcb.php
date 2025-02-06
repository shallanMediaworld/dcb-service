<?php
return [

    'uuid' => null,
    /*
     * Determine whether to stringify the status code in the JSON response's body.
     */
    'stringify' => true,

    /*
     * Set the status code from the JSON response to be the same as the status code
     * in the JSON response's body.
     */
    'match_status' => true,

    /*
     * Include the count of the "data" in the JSON response.
     */
    'include_data_count' => false,

    /*
     * Configuration for different operators.
     */
    'operators' => [
        'batelco' => [
            'disabled' => true,
            'host' => env('BATELCO_HOST', 'https://mediaworldsdp.com/api'),
            'info' => [
                'api_key' => env('BATELCO_API_KEY', '1660221ebe94ac2b58747596839ab4e5'),
                'channel_id' => env('BATELCO_CHANNEL_ID', '12'),
            ],

            'limit_request' => 1,

        ],
        'jawwal' => [
            'disabled' => true,
            'host' => env('JAWWAL_HOST', 'http://jawwal.mediaworldiq.com/dcb/API'),
            'info' => [
                'user' => env('JAWWAL_USER', 'mediaworld'),
                'password' => env('JAWWAL_PASSWORD', 'medi@w0rld@20!'),
                'shortcode' => env('JAWWAL_SHORTCODE', '500010'),
                'serviceId' => env('JAWWAL_SERVICE_ID', '10982'),
                'spId' => env('JAWWAL_SP_ID', '5010'),
            ],

            'limit_request' => 5
        ],
        'mobily' => [
            'disabled' => true,
            'host' => env('MOBILY_HOST', 'https://mediaworldsdp.com/en/api'),
            'info' => [
                'api_key' => env('MOBILY_API_KEY', '9fc32d6aafbd0e3a197891751f265180'),
                'channel_id' => env('MOBILY_CHANNEL_ID', '4'),
            ],

            'limit_request' => 5
        ],
        'vodafone' => [
            'disabled' => true,
            'host' => env('VODAFONE_HOST', 'https://mediaworldsdp.com/api'),
            'info' => [
                'api_key' => env('VODAFONE_API_KEY', '36e85527c07d8379fa7d8ffc760fb44b'),
                'channel_id' => env('VODAFONE_CHANNEL_ID', '2'),
            ],
            'limit_request' => 5
        ],
        'sabafon' => [
            'disabled' => true,
            'host' => env('SABAFON_HOST', 'http://jawwal.mediaworldiq.com/dcb/API'),
            'info' => [
                'user' => env('SABAFON_USER', 'mediaworld'),
                'password' => env('SABAFON_PASSWORD', 'medi@w0rld@20!'),
                'shortcode' => env('SABAFON_SHORTCODE', '3045'),
                'serviceId' => env('SABAFON_SERVICE_ID', '48'),
                'spId' => env('SABAFON_SP_ID', '3'),
            ],

            'limit_request' => 5
        ],
        'zain' => [
            'disabled' => true,
            'host' => env('ZAIN_HOST','https://services.mediaworldiq.com:456/dcb/API'),
            'info' => [
                'user' => env('ZAIN_USER', 'mediaworld'),
                'password' => env('ZAIN_PASSWORD', 'medi@w0rld@20!'),
                'shortcode' => env('ZAIN_SHORTCODE', '4049'),
                'serviceId' => env('ZAIN_SERVICE_ID', '231'),
                'spId' => env('ZAIN_SP_ID', '2'),
            ],
            'limit_request' => 5
        ],
        'zain_bahrain' => [
            'disabled' => false,

        ],
        'zain_ksa' =>  [
            'disabled' => true,
            'host' => env('ZAIN_KSA_HOST', 'https://mediaworldsdp.com/en/api'),
            'info' => [
                'api_key' => env('ZAIN_KSA_API_KEY', '2aaccd5977da9f378e73e19152a45606'),
                'channel_id' => env('ZAIN_KSA_CHANNEL_ID', '9'),
            ],
            'limit_request' => 5
        ],
    ],

    /*
     * Mapping of operator names to their corresponding provider classes.
     */
    'providers' => [
        'batelco' => \App\src\DCB\Batelco::class,
        'jawwal' => \App\src\DCB\Jawwal::class,
        'mobily' => \App\src\DCB\Mobily::class,
        'vodafone' => \App\src\DCB\Vodafone::class,
        'sabafon' => \App\src\DCB\Sabafon::class,
        'zain' => \App\src\DCB\Zain::class,
        'zain_bahrain' => \App\src\DCB\ZainBahrain::class,
        'zain_ksa' => \App\src\DCB\ZainKsa::class,
    ],

    /*
     * Table mapping for transactions.
     */
    'tables' => [
        'transaction' => [
            "class" => \App\Models\Sale::class,
            "id" => null,
            "column_name" => 'id',
        ],
        'cart' => [
            "class" =>  \App\Models\User_cart::class,
            "id" => null,
            "column_name" => 'group_id',
        ]
    ],

    'table_name' => 'transaction',
     'dcb_available'=>[]
];
