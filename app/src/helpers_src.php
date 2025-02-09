<?php

use App\ServicesData\Logs\LogsService as logsService;
use Illuminate\Http\JsonResponse;
use App\src\DcbResponse;
use App\src\Contracts\DcbInterface;

use function PHPUnit\Framework\isNull;

if (!function_exists('dcb')) {
    /**
     * Create a new instance of DcbInterface without configuration.
     *
     * @return DcbInterface
     */
    function dcb()
    {
        return app(DcbInterface::class);
    }
}

if (!function_exists('dcbInt')) {
    /**
     * Create a new instance of DcbInterface with configuration.
     *
     * @param string $operator
     * @return DcbInterface
     */
    function dcbInt($operator)
    {
        return app(DcbInterface::class)->config($operator);
    }
}




if (!function_exists('sendMessage')) {
    /**
     * Perform a check OTP operation.
     *
     * @param string $operator
     * @param string $phone
     * @param string $price
     * @param string $otp
     * @param mixed ...$extraData
     * @return JsonResponse
     */
    function sendMessage($operator, $phone, $message)
    {
        $dcb = dcbInt($operator);

        if ($dcb === null) return false;


        return $dcb->sendMessage($phone, $message);
    }
}


if (!function_exists('checkOtp')) {
    /**
     * Perform a check OTP operation.
     *
     * @param string $operator
     * @param string $phone
     * @param string $price
     * @param string $otp
     * @param mixed ...$extraData
     * @return JsonResponse
     */
    function checkOtp($operator, $phone, $price, $otp, ...$extraData)
    {
        $dcb = dcbInt($operator);

        if ($dcb === null) return false;

        return $dcb->checkOtp($phone, $price, $otp, ...$extraData);
    }
}

if (!function_exists('sendOtp')) {
    /**
     * Perform a send OTP operation.
     *
     * @param string $operator
     * @param string $phone
     * @param string $price
     * @param mixed ...$extraData
     * @return JsonResponse
     */
    function sendOtp($operator, $phone, $price, ...$extraData)
    {
        $dcb = dcbInt($operator);

        if ($dcb === null) return false;

        return $dcb->sendOtp($phone, $price, ...$extraData);
    }
}



if (!function_exists('cehckLimit')) {
    /**
     * Perform a send OTP operation.
     *
     * @param string $operator
     * @param string $quantity
     * @return JsonResponse
     */
    function cehckLimit($operator, $quantity)
    {

        $dcb = dcbInt($operator);


        if ($dcb === null) return false;

        return $dcb->cehckLimit($quantity);
    }
}


if (!function_exists('operatorAvailable')) {
    /**
     * Enable cart and set the cart ID in configuration.
     *
     * @param int $cart_id
     * @return void
     */
    function operatorAvailable()
    {
  
        $dcb = dcb();
       
        return $dcb->operatorAvailable();
    }
}
