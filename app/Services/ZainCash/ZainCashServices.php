<?php

namespace App\Services\ZainCash;

use App\Models\User_wallet;
use App\Models\User;
use App\Models\User_wallet_log;
use App\Models\Wallet;
use App\Models\Zaincash;
use App\Models\ZainTransation;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class ZainCashServices
{

    private $secret,  $merchantid,  $msisdn, $language, $phone, $ip ,$redirection_url ,$urlInit ,$urlPay ,$driver;
    
    public function __construct(array $info,array $data)
    {
        $this->language = $data['language'] ?? "en";
        $this->phone = $data['phone'] ?? null;
        $this->ip =  $data['ip'] ?? null;
        $driver =  $info["driver"] ;
        
        $credantial= config('zaincash.'.$driver);
  
        $this->secret = $credantial['secret_zain_cash'];
        $this->merchantid = $credantial['merchant_id_zain_cash'];
        $this->msisdn = $credantial['msdin_zain_cash'];
        $this->redirection_url = $data['redirection_url'] ?? '' . env('APP_FRONT') . '/checkout/' . $this->language . '/';
        $this->driver = $driver;

        $this->urlInit = 'https://test.zaincash.iq/transaction/init';
        $this->urlPay = 'https://test.zaincash.iq/transaction/pay?id=';
    }

    public function setPhone($phone){

        $this->phone = $phone;
    }

    public function setIP($ip){

        $this->ip = $ip;
    }
    
    public function create_transaction($amount, $data)
    {
        try {

            $service_type = $data["service_type"] ?? "A 3abee";
            $order_id =  $data["order_id"] ?? "Bill_1234567890";
  
            ZainTransation::insertGetId([]);

            $data = [
                'amount'  => $amount,
                'serviceType'  => $service_type,
                'msisdn'  => $this->msisdn, // Your wallet phone number
                'orderId'  => $order_id,
                'redirectUrl'  => $this->redirection_url,
                'iat'  => time(),
                'exp'  => time() + 60 * 60 * 4,
            ];

            //Encoding Token
            $newtoken = JWT::encode(
                $data,      //Data to be encoded in the JWT
                $this->secret,
                'HS256' // secret is requested from ZainCash
            );




            //POSTing data to ZainCash API
            $data_to_post = array();
            $data_to_post['token'] = urlencode($newtoken);
            $data_to_post['merchantId'] = $this->merchantid; // Your merchant ID is requested from ZainCash
            $data_to_post['lang'] = $this->language;
            
            logInfo(__FUNCTION__, ["data_to_post" => $data_to_post,'useLog'=>"Zain Cash"], "zaaincash :".$this->driver);

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method'  => 'POST',
                    'content' => http_build_query($data_to_post),
                ),
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                )
            );

            $context  = stream_context_create($options);

            $response = file_get_contents($this->urlInit, false, $context);
      
            //Parsing response
            $array = json_decode($response, true);

            logInfo(__FUNCTION__, ["response" => $response,'useLog'=>"Zain Cash"], "zaaincash :".$this->driver);

            $transaction_id = $array['id'];
            $newurl = $this->urlPay . $transaction_id;


            // Log::channel('3ABEE_LOGGER')->alert("[IP: " . $ip . "] [MSISDN: $phone] [ZAIN_CASH] Create Transaction sent successfully");

            $zaincash = new Zaincash();
            $zaincash->transaction_id = $array['id'];
            $zaincash->source = $array['source'];
            $zaincash->type = $array['type'];
            $zaincash->amount = $array['amount'];
            $zaincash->to = $array['to'];
            $zaincash->serviceType = $array['serviceType'];
            $zaincash->lang = $array['lang'];
            $zaincash->orderId = $array['orderId'];
            $zaincash->currencyConversion = implode($array['currencyConversion']);
            $zaincash->referenceNumber = $array['referenceNumber'] ?? '';
            $zaincash->redirectUrl = $array['redirectUrl'] ?? "";
            $zaincash->credit = $array['credit'];
            $zaincash->status = $array['status'];
            $zaincash->reversed = $array['reversed'];
            $zaincash->driver =  $this->driver;
            $zaincash->createdAt = $array['createdAt'];
            $zaincash->updatedAt = $array['updatedAt'];
            $zaincash->save();


            $last_ZainTransation = ZainTransation::latest('id')->first();
            $last_ZainTransation->transaction_id = $array['id'];
            $last_ZainTransation->save();

            logInfo(__FUNCTION__, ["zaincash" => $zaincash,'useLog'=>"Zain Cash"], "zaaincash :".$this->driver);

            return ['status' => true, 'message' => 'success', 'data' => $array];

        } catch (Throwable $e) {
            
            logInfo(__FUNCTION__, ['dataError' => $e->getMessage(), "line" => $e->getLine(),'useLog'=>"Zain Cash"], "zaaincash :".$this->driver);

            return ['status' => false, 'message' => 'error', 'data' => [], 'dataError' => $e->getMessage(), "line" => $e->getLine()];
        }
    }

    public function check_transaction($transaction_id, $user_id = null)
    {

        try {

            $id = $transaction_id;
       
            logInfo(__FUNCTION__,  ["message" => ["transaction_id" => $transaction_id, "user_id" => $user_id]],'zaaincash');
 
            //building data
            $data = [
                'id'  => $id,
                'msisdn'  => $this->msisdn,
                'iat'  => time(),
                'exp'  => time() + 60 * 60 * 4
            ];


            //Encoding Token
            $newtoken = JWT::encode(
                $data, //Data to be encoded in the JWT
                $this->secret,
                'HS256'
            );

            //POST data to ZainCash API
            $data_to_post = array();
            $data_to_post['token'] = urlencode($newtoken);
            $data_to_post['merchantId'] = $this->merchantid;

            $options = array(
                'http' => array(
                    'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                    'method' => 'POST',
                    'content' => http_build_query($data_to_post),
                ),
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );

            logInfo('Options Check Transaction',  ["message" => $options]);

            $context = stream_context_create($options);
            $response = file_get_contents('https://test.zaincash.iq/transaction/pay?id=', false, $context);

            $array = json_decode($response, true);
            logInfo(__FUNCTION__, ["response" => $response,'useLog'=>"Zain Cash"], "zaaincash :".$this->driver);

            return  ['status' => true, 'message' => 'success', 'data' => $array];
        } catch (\Throwable $e) {

            logInfo(__FUNCTION__, ['dataError' => $e->getMessage(), "line" => $e->getLine(),'useLog'=>"Zain Cash"], "zaaincash");

            return ['status' => false, 'message' => 'error'];
        }
    }
}
