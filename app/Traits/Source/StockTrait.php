<?php

namespace App\Traits\Source;

use App\Models\Source;
use App\Models\ez_auth;
use App\Classes\AesCtr;
use Illuminate\Support\Facades\Log;

trait StockTrait {

    private static $server;
    private static $date;
    public function __construct()
    {
        self::$server = ( env("SERVER") == "TEST" ) ? "T" : "L";
        self::$date = gmdate("Ymd\THis\Z");
    }

    protected function mintRoute($sku)
    {
        // Prepare request
        $url = Source::MR_STOCK;
        $params = [
            "username" => env(self::$server . "_USERNAME"),
            "password" => env(self::$server . "_PASSWORD"),
            "data" => "[{denomination_id:$sku}]"
        ];
        $json = json_encode($params);

        $public_key = env(self::$server . "_PUBLIC_KEY");
        $private_key = env(self::$server . "_PRIVATE_KEY");

        $aesctr = new AesCtr();
        $postedinfo = $aesctr->encrypt($json, $private_key, 256);
        $token = base64_encode($public_key);
        $post = http_build_query(array("postedinfo" => $postedinfo, "token" => $token));

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

    protected function oneCard($sku)
    {
        // Prepare request
        $resellerUsername = env(self::$server . "_OC_POS_USERNAME");
        $secret = env(self::$server . "_OC_SECRET");
        $signature = md5($resellerUsername . $sku . $secret);
        $url = env(self::$server . "_OC_URL") . "product-detailed-info";

        $params = [
            'resellerUsername' => $resellerUsername,
            'password' => $signature,
            'productID' => $sku,
        ];
        $json = json_encode($params);

        $ch = curl_init($url);
        $payload = json_encode($json);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        $response = json_decode($result, true);
        curl_close($ch);

        return $response;
    }

    protected function ezPin($sku, $price)
    {
        // Prepare request
        $retries = 5;
        $available = false;
        $url = "https://api.ezpaypin.com/vendors/v2/catalogs/$sku/availability/";
        $urlParams = "$url?item_count=1&price=$price";

        while( $retries > 0 ) {
            try {
                $token = generate_ez_pin_authenticate();
                if( !empty($token) ) {
                    $curl = curl_init($url);
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Authorization:Bearer " . $token));
                    curl_setopt($curl, CURLOPT_URL, $urlParams);
                    $response = curl_exec($curl);
                    curl_close($curl);
                    log::channel("3ABEE_LOGGER")->emergency("[TEST AVAI resp: $response] EZPIN AVAI RESP");

                    $json = json_decode($response, true);

                    if( array_key_exists("availability", $json) && isset($json["availability"]) ) {
                        $available = $json["availability"] ? true : false;
                    }
                    elseif( array_key_exists("code", $json) && isset($json["code"]) ) {
                        if ($json["code"] == "token_not_valid") {
                            ez_auth::truncate();
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

                return $available;
            } catch(\Throwable $exception) {
                return false;
            }
        }
    }
}