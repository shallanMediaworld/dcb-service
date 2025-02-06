<?php
return [

      "dcb_available" => [],

        'wallet' =>  [
            'disabled' => true,
            'host' => '',
            'info' => [
                'id' => env('walle', 17),
                'country_id' => env('walle', 15),
            ],
            'limit_request' => 5
        ],
    

      "e-wallet" => 'e-wallet',

      "alias_name" => [
            "wallet",
            "e-wallet" // Corrected syntax issue here
      ],

];
