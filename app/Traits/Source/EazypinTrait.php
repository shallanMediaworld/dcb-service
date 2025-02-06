<?php

namespace App\Traits\Source;

use App\Models\Source;
use App\Models\ez_auth;
use Illuminate\Support\Facades\Log;

trait EazypinTrait {



    public static function ezpin($sku, $price)
    {
        $retries = 5;
        $available = false;

        while ($retries > 0) {
            try {
                $auth = generate_ez_pin_authenticate();
                if (!empty($auth)) {
                    $url = 'https://api.ezpaypin.com/vendors/v2/catalogs/' . $sku . '/availability/';
                    $data = "item_count=1" .
                        "&price=" . $price . "";
                    $getUrl = $url . "?" . $data;
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization:Bearer ' . $auth));
                    curl_setopt($curl, CURLOPT_URL, $getUrl);
                    $response = curl_exec($curl);
                    log::channel('3ABEE_LOGGER')->emergency("[TEST AVAI resp: $response] EZPIN AVAI RESP");
                    curl_close($curl);
                    $json = json_decode($response, true);

                    if (isset($json['availability'])) {
                        $available = $json['availability'] ? true : false;
                    } elseif (isset($json['code'])) {
                        if ($json['code'] == 'token_not_valid') {
                            \App\Models\ez_auth::truncate();
                            $token = generate_ez_pin_authenticate();
                            return $token;
                        } else {
                            $available = false;
                        }
                    } else {
                        $available = false;
                    }
                } else {
                    $available = false;
                }
                $retries = 0;
                return $available;
            } catch (\Exception $e) {
                return false;
            }
        }
    }


}