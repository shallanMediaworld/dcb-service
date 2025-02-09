<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DCB\DCBServices;
use Illuminate\Http\Request;

class DCBController extends Controller
{

    /**
     * @return json 
     * 
     */
    public function sendOtp(Request $request)
    {


       $dcb =  new DCBServices();
    //    $dcb =  $dcb->sendOtp("");
       
        return  response()->json([
            "success" => 2,
            "message" => "OTP successfully sent to the registered mobile number.",
            "code" => 1025,
            "data" => [
                "transaction_id" =>   "Z8A3B2C7121212321231"
            ]
        ], 200);
    }
}
