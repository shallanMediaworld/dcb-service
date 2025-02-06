<?php

namespace App\src\Contracts;

use Illuminate\Http\JsonResponse;

interface DcbInterface
{


        /**
     * Create API check_otp.
     *
     * @param string    $phone
     * @param string $otp
     * @param string  $ip
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function checkOtp($phone,$price ,$otp,...$extraData);


    /**
     * Create API check_otp.
     *
     * @param int    $status
     * @param string $message
     * @param array  $data
     * @param array  $extraData
     *
     * @return JsonResponse
     */
    public function sendOtp($phone, $price,...$extraData);



}
