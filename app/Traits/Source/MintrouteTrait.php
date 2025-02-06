<?php

namespace App\Traits\Source;

use App\Models\Source;
use App\Models\ez_auth;
use App\Classes\AesCtr;
use Illuminate\Support\Facades\Log;

trait MintrouteTrait {

    
    public static function mintRoute($sku)
    {
        $server = ( env("SERVER") == "TEST" ) ? "T" : "L";

        $url = 'https://mconnect2.mintroute.com/voucher/api/stock';
        $json = '{"username":"' . env('' . $server . '_USERNAME') . '","password":"' . env('' . $server . '_PASSWORD') . '","data":[{"denomination_id":' . $sku . '}]}';
        $public_key = env('' . $server . '_PUBLIC_KEY');
        $private_key = env('' . $server . '_PRIVATE_KEY');
        $aesctr = new AesCtr();
        $postedinfo = $aesctr->encrypt($json, $private_key, 256);
        $token = base64_encode($public_key);

        $post = http_build_query(array('postedinfo' => $postedinfo, 'token' => $token));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTPS);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

}