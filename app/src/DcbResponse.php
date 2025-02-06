<?php

namespace App\src;

use App\Services\Logs\LogsService;
use App\src\Contracts\DcbInterface;
use App\src\Response\Response;
use Illuminate\Support\Str;
use Throwable;

use function PHPUnit\Framework\isNull;

class DcbResponse implements DcbInterface
{
    private $className;
    private $operator;
    private $response;
    private $successful;
    private $dataConfig;

    /**
     * Initialize the DcbResponse instance.
     */
    public function __init__()
    {
        $this->response = new Response($this->operator);

        return $this;
    }

    /**
     * Configure the DcbResponse instance for a specific operator.
     *
     * @param string $operator
     *
     * @throws \InvalidArgumentException
     */
    public function config($operator)
    {

        $this->validateOperator($operator);


        try {
            $config = config('dcb');
            $this->operator = $operator;

            $this->configureProvider($config['providers'][$operator], $config);
        } catch (Throwable $e) {

            $this->logs(__FUNCTION__, ["error" => $e->getMessage(), "line" => $e->getLine()]);

            return false;
        }

        return $this->__init__();
    }



    /**
     * Handle the sendMessage operation.
     *
     * @param string $phone
     * @param string $final_msg
     *
     * @return Response
     */
    public function sendMessage($phone, $final_msg)
    {

        $this->className->sendMessage($phone, $final_msg);
        return true;
    }

    /**
     * Handle the check OTP operation.
     *
     * @param string $phone
     * @param string $price
     * @param string $otp
     * @param mixed  ...$extraData
     *
     * @return Response
     */
    public function checkOtp($phone, $price, $otp, ...$extraData)
    {
        $content = $this->className->checkOtp($phone, $price, $otp, ...$extraData);
        return $this->handleResponse($content);
    }

    /**
     * Handle the send OTP operation.
     *
     * @param string $phone
     * @param string $price
     * @param mixed  ...$extraData
     *
     * @return Response
     */
    public function sendOtp($phone, $price, ...$extraData)
    {

        $content = $this->className->sendOtp($phone, $price, ...$extraData);

        return $this->handleResponse($content);
    }

    /**
     * Set up the DcbResponse instance for a specific provider.
     *
     * @param string $className
     * @param array  $config
     */
    private function configureProvider(string $className, array $config): void
    {
        $table = $this->getTable($config['tables'], $config['table_name']);
        $provider = new $className();
        $this->dataConfig =   $provider->config($this->operator, $config, $table);

        $this->className = $provider;
    }

    /**
     * Retrieve table information.
     *
     * @param array  $tables
     * @param string $tableName
     *
     * @return mixed
     */
    private function getTable(array $tables, string $tableName)
    {
        $tableInfo = $tables[$tableName];
        $tableClass = $tableInfo['class'];
        return $tableClass::where($tableInfo['column_name'], $tableInfo['id'])->first();
    }

    /**
     * Handle the response from the provider.
     *
     * @param mixed $content
     *
     * @return Response
     */
    private function handleResponse($content)
    {
        $code = $content->code ?? 0;
        $response = $this->response->messages('code', $code);
        $this->successful = $response->successful ?? false;
        return $response;
    }

    /**
     * Validate the provided operator.
     *
     * @param string $operator
     *
     * @throws \InvalidArgumentException
     */
    private function validateOperator(string $operator = null): void
    {

        if ($operator === null || !isset(config('dcb')['operators'][$operator])) {

            $this->logs(__FUNCTION__, ["error" => "Unknown operator: $operator"]);

            throw new \InvalidArgumentException("$operator");
        }
    }


    public function setCartConfig(int $cart_id, $quantity = null): void
    {
        $batchId = Str::uuid();
        $configData = [
            'dcb.tables.cart.cart_id' => $cart_id,
            'dcb.tables.cart.id' => $cart_id,
            'dcb.table_name' => 'cart',
            'dcb.uuid' => $batchId
        ];
        $this->setConfig($configData);
    }

    private function setConfig(array $configData): void
    {
        foreach ($configData as $key => $value) {
            config([$key => $value]);
        }
    }


    private function logs($action, array $data = [])
    {
        $action = is_string($action) ? $action : '';

        $confLog = [
            "operator" => $this->operator,
            "data" => $data
        ];

        LogsService::logsOperator($action, $this->operator, $confLog);
    }

    /**
     * Retrieve table information.
     *
     * @param array  $tables
     * @param string $tableName
     *
     * @return mixed
     */
    public function cehckLimit(int $quantity)
    {

        $dataConfig =  $this->dataConfig;
        $limit_request = $dataConfig['limit_request'] ?? 1;

        return ($limit_request >= $quantity);
    }



    public function  operatorAvailable()
    {

        try {
            $config = config('dcb');
            $operator =   collect($config['operators'])->where('disabled', true);

            return  (array) $operator->keys()->toArray();
        } catch (Throwable  $e) {
            return [];
        }
    }
}
