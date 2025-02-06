<?php

namespace App\Traits\Source;

use App\Models\Source;
use App\Models\ez_auth;
use Illuminate\Support\Facades\Log;

trait OneCardTrait {


    public static function onecard($sku)
    {
        $server = ( env("SERVER") == "TEST" ) ? "T" : "L";
        //Product detailed info
        $resellerUsername = env($server . '_OC_POS_USERNAME');
        $secret = env($server . '_OC_SECRET');
        $signature = md5($resellerUsername . $sku.$secret);
        $url = env($server . '_OC_URL') . 'product-detailed-info';
        $ch = curl_init($url);
        $data = array(
            'resellerUsername' => $resellerUsername,
            'password' => $signature,
            'productID' => $sku,
        );
        $payload = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $response = json_decode($result,true);
        curl_close($ch);
        return $response;
    }

}