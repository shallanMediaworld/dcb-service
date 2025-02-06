<?php

namespace App\Services\ZainCash;

use App\Models\ZainTransation;
use App\Models\Zaincash;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Throwable;

class ZainCashServices3
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://test.zaincash.iq/',
            'verify' => false  // Ideally, you should enable SSL verification
        ]);
    }

    public function create_transaction($phone, $ip, $language, $amount, $redirection_url): JsonResponse
    {
        try {
            $data = [
                'amount' => $amount,
                'serviceType' => "A book2",
                'msisdn' => "9647835077893",
                'orderId' => "Bill_1234567890",
                'redirectUrl' => $redirection_url,
                'iat' => time(),
                'exp' => time() + 60 * 60 * 4,
            ];

            $newtoken = JWT::encode($data, env('ZAINCASH_SECRET'), 'HS256');

            $response = $this->client->post('transaction/init', [
                'form_params' => [
                    'token' => $newtoken,
                    'merchantId' => env('ZAINCASH_MERCHANT_ID'),
                    'lang' => $language,
                ]
            ]);

            $array = json_decode($response->getBody()->getContents(), true);
            $zaincash = $this->saveZainCashTransaction($array);
            $this->logTransactionInit($ip, $phone);

            return response()->json(['status' => true, 'message' => 'success', 'data' => $array]);
        } catch (RequestException $e) {
            Log::error('API request failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'API request failed', 'dataError' => $e->getMessage()]);
        } catch (Throwable $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'Unexpected error occurred', 'dataError' => $e->getMessage(), "line" => $e->getLine()]);
        }
    }

    public function check_transaction($transaction_id, $user_id): JsonResponse
    {
        try {
            $data = [
                'id' => $transaction_id,
                'msisdn' => "9647835077893",
                'iat' => time(),
                'exp' => time() + 60 * 60 * 4
            ];

            $newtoken = JWT::encode($data, env('ZAINCASH_SECRET'), 'HS256');

            $response = $this->client->post('transaction/pay', [
                'form_params' => [
                    'token' => urlencode($newtoken),
                    'merchantId' => env('ZAINCASH_MERCHANT_ID'),
                ]
            ]);

            $array = json_decode($response->getBody()->getContents(), true);

            return response()->json(['status' => true, 'message' => 'success', 'data' => $array]);
        } catch (RequestException $e) {
            Log::error('API request failed: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'API request failed', 'dataError' => $e->getMessage()]);
        } catch (Throwable $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            return response()->json(['status' => false, 'message' => 'Unexpected error occurred', 'dataError' => $e->getMessage(), "line" => $e->getLine()]);
        }
    }

    protected function saveZainCashTransaction($data)
    {
        $zaincash = new Zaincash();
        $zaincash->fill($data);
        $zaincash->save();
        return $zaincash;
    }

    protected function logTransactionInit($ip, $phone)
    {
        Log::channel('ZainCash')->info("Transaction initiated by IP: {$ip}, MSISDN: {$phone}");
    }
}
