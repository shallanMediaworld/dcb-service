<?php

namespace App\src\DCB;

use App\src\Contracts\DcbInterface;

use App\Services\Logs\LogsService;
use GuzzleHttp\Client;

class ZainKsa  implements DcbInterface
{
    private $queryParams, $operator,  $client;
    protected static $base_uri, $countent, $limit_request;
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

        $data_config = $config['operators'][$operator]['info'];
        self::$limit_request = $config['operators'][$operator]['limit_request'];

        $this->queryParams = [
            'api_key' => $data_config['api_key'],
            'channel_id' => $data_config['channel_id']
        ];

        self::$countent = (object) [
            "error" => true,
            "code" => 0,
            "message" => "",
            "x-tracking-id" => "",
            "statusCode" => 0
        ];

        return [
            "limit_request" => self::$limit_request,
            "data_config" => self::$base_uri,
            "base_uri" => self::$base_uri,
        ];
    }

    public function checkOtp($phone, $price, $otp, ...$extraData)
    {


        $query = [
            "msisdn" => $phone,
            "pincode" => $otp,
            "price" => $price,
        ];

        $url = self::$base_uri . '/get/users.subscribe_pincode/';

        $this->logs(__FUNCTION__, ["query" => [$query, $this->queryParams], $url => $url]);

        $this->endPoint($query, $url);

        $this->logs(__FUNCTION__, ["countent" => self::$countent]);

        return self::$countent;
    }

    public function sendOtp($phone, $price, ...$extraData)
    {

        $query = [
            "msisdn" => $phone,
            "async" => 0,
            "price" => $price,
            "app_id" => $extraData[0]["app_id"] ?? null,
        ];

        $url = self::$base_uri . '/get/users.send_pincode/';

        $this->logs(__FUNCTION__, ["query" => [$query, $this->queryParams], $url => $url]);

        $this->endPoint($query, $url);

        $this->logs(__FUNCTION__, ["countent" => self::$countent]);

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

        $this->logs(__FUNCTION__, ["getBody" => $countent, 'statusCode' => $statusCode]);

        self::$countent = self::$countent->merge([
            'statusCode' => $statusCode,
            'code' => $countent['code'] ?? 0,
        ]);

        self::$countent = (object) self::$countent->toArray();

        return !$error;
    }

    public function sendMessage($phone, $message)
    {
        $query = [
            "msisdn" => $phone,
            "message" => $message,
        ];

        $url = self::$base_uri . '/get/users.send_mt';

        $this->logs(__FUNCTION__, ["query" => [$query, $this->queryParams], $url => $url]);

        $this->endPoint($query, $url);

        $this->logs(__FUNCTION__, ["countent" => self::$countent]);
    }


    
}
