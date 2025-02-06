<?php

namespace App\src;

use App\Services\Logs\LogsService;
use Illuminate\Support\Traits\Macroable;
use App\src\Contracts\DcbInterface;
use App\src\Response\Response;
use Illuminate\Support\Str;
use Throwable;

class DcbResponse implements DcbInterface
{
    use Macroable;

    private $config, $className, $operator, $response, $successful;

    public function __init__()
    {
        $this->response =  new Response($this->operator);
    }

    /**
     * Create DCB check_otp.
     *
     * @param string    $phone
     * @param string $otp
     * @param string  $ip
     * @param array  $extraData
     *
     * @return Response
     */
    public function checkOtp($phone, $price, $otp, ...$extraData)
    {
        $conntent = $this->className->sendOtp($phone, $price);
        return $this->handel($conntent);
    }

    /**
     * Create DCB check_otp.
     *
     * @param int    $status
     * @param string $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return Response
     */
    public function sendOtp($phone, $price, ...$extraData)
    {
        $conntent = $this->className->sendOtp($phone, $price);
        return $this->handel($conntent);
    }


    private function handel($countent)
    {

        $code = $countent->code ?? 0;

        $response =  $this->response->messages('code', $code);
        $this->successful = $response->successful ?? false;

        return $response;
    }

    public function cartOn(int $cart_id)
    {
        $batchId = Str::uuid();
        config(['dcb.tables.cart.cart_id' => $cart_id]);
        config(['dcb.tables.cart.id' => $cart_id]);
        config(['dcb.table_name' => 'cart']);
        config(['dcb.uuid' => $batchId]);
    }


    public function config($operator)
    {
        $config = config('dcb');
        $this->operator =  $operator;

        if (!isset($config['operators'][$operator])) {
            throw new \InvalidArgumentException(": $operator");
        }

        $operatorConfig = $config['providers'][$operator];

        $this->configureProvider($operatorConfig, $operator, $config);

        $this->init();

        return $this;
    }


    private function configureProvider(string $className, string $operator, array $config): void
    {
        try {
            
            $table =  $this->table($config['tables'], $config['table_name']);
            $provider = new $className();
            $provider->config($operator,  $config, $table);
            $this->className = $provider;

        } catch (Throwable $e) {

            throw new \InvalidArgumentException(" Configure Provider Unknown operator: $operator");
        }
    }

    private function table(array $tables, $table_name)
    {
        $table  =  $tables[$table_name];
        $tableClass = $table['class'];

        return  $tableClass::where($table['column_name'], $table['id'])->first();
    }


    private function logs($action, $data = [])
    {

        $confLog = [
            "operator" => $this->operator,
            "data" => $data,
        ];

        LogsService::logsOperator($action, $this->operator, $confLog);
    }
}
