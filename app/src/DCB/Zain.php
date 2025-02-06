<?php

namespace App\src\DCB;

use App\Services\Logs\LogsService;
use App\src\Contracts\DcbInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class Zain implements DcbInterface
{
    private $queryParams, $operator,  $client;
    protected static $base_uri, $countent ,$limit_request;
    protected $tableClass, $cart_id, $table;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function config($operator, $config, $table)
    {
        $this->table =  $table;
        $this->operator = $operator;
        self::$base_uri = $config['operators'][$operator]['host'];
        self::$limit_request = $config['operators'][$operator]['limit_request'];

        $data_config = $config['operators'][$operator]['info'];

        $this->queryParams = [
            'user' => $data_config['user'],
            'password' => $data_config['password'],
            'shortcode' => $data_config['shortcode'],
            'serviceId' => $data_config['serviceId'],
            'spId' => $data_config['spId'],
        ];

        self::$countent = (object) [
            "error" => true,
            "code" => 0,
            "message" => "",
            "x-tracking-id" => "",
            "statusCode" => 0
        ];

        return [
            "limit_request"=>self::$limit_request,
            "data_config"=>self::$base_uri ,
            "base_uri"=>self::$base_uri ,
        ];
 
    }



    public function sendOtp($phone, $price, ...$extraData)
    {
 

        $query = [
            "msisdn" => $phone,
        ];

        $url = self::$base_uri . '/VMS-OneTimePurchaseNoBilling/actions/sendPincode';

        $this->logs(__FUNCTION__, ["query" => [$query, $this->queryParams], $url => $url]);

        $this->endPoint($query, $url);

        $this->logs(__FUNCTION__, ["countent" => self::$countent]);

        if (self::$countent->status === "Success")
            self::$countent->code = 200;


        return self::$countent;
    }

 
    public function checkOtp($phone, $price, $otp, ...$extraData)
    {
        $query = [
            "msisdn" => $phone,
            "pincode" => $otp,
            "price" => $price,
        ];

        $url = self::$base_uri . '/VMS-OneTimePurchaseNoBilling/actions/verifyPincode';

        $this->logs(__FUNCTION__, ["query" => [$query, $this->queryParams], $url => $url]);

        $this->endPoint($query, $url);

        $this->logs(__FUNCTION__, ["countent" => self::$countent]);

        self::$countent->message = self::$countent->msg;

        if (self::$countent->status !== "Success") {
            self::$countent->code = 401;
            return self::$countent;
        }

        $this->charging($phone, $price);

        return self::$countent;
    }



    protected function charging($phone, $price, ...$extraData)
    {
        $query = [
            "msisdn" => $phone,
            "price" => $price,
        ];

        $url = self::$base_uri . '/VMS-DynamicDirectBilling/actions/charge';

        $this->logs(__FUNCTION__, ["query" => [$query, $this->queryParams], $url => $url]);

        $this->endPoint($query, $url);

        $this->logs(__FUNCTION__, ["countent" => self::$countent]);

        self::$countent->message = self::$countent->msg;


        if (self::$countent->status !== "Success")
            self::$countent->code = 401;
        else
            self::$countent->code = 200;

        return self::$countent;
    }




    private function logs($action, $data = [])
    {
        $action = is_string($action) ? $action : '';

        $confLog = [
            "operator" => $this->operator,
            "data" => $data,
            'performedOn' => $this->table,
        ];

        LogsService::logsOperator($action, $this->operator, $confLog);
    }

    public function sendMessage($phone ,$final_msg){


        $query = [
            "msisdn" => $phone,
            "final_msg" => $final_msg,
        ];
        $final_msg = bin2hex(mb_convert_encoding($final_msg, 'UCS-2', 'auto')) ;

        $url = self::$base_uri . '/dcb/API/VMS-SMS/actions/sendSMS';

        $this->logs(__FUNCTION__, ["query" => [$query, $this->queryParams], $url => $url]);

        $this->endPoint($query, $url);

        $this->logs(__FUNCTION__, ["countent" => self::$countent]);
       
    }

    private  function endPoint($query, $endpoint)
    {
        $new_query = array_merge($this->queryParams, $query);
        $error = false;
 
        try {
            $http_client = new Client([
                "base_uri" => self::$base_uri,
                "query" => $new_query
            ]);

            $response = $http_client->get($endpoint);
            $countent = json_decode($response->getBody()->getContents(), true);  
     
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            
            $response = $e->getResponse();
            $countent = json_decode($response->getBody()->getContents(), true);  
            $error = true;
        }

        $statusCode =  $response->getStatusCode();
       
        self::$countent = collect($countent);

        $this->logs(__FUNCTION__, ["getBody" => $countent,'statusCode'=> $statusCode]);

        self::$countent = self::$countent->merge([
            'statusCode' => $statusCode ,
            'code' => $countent['code'] ?? 0,
        ]);
        
        self::$countent = (object) self::$countent->toArray();

        return !$error;
    }
}