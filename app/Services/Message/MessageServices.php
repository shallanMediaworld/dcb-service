<?php

namespace App\Services\Message;


use App\Jobs\SendVoucherJob;
use App\Models\Payment_channel;
use App\Models\PaymentPrices;
use App\Models\Sale;
use App\Services\DCB\DCBServices;
use App\Services\Source\ServicesVoucher;
use Throwable;

class MessageServices
{
    private $operator, $DCBServices;

    public function __construct()
    {
        $this->DCBServices =  new DCBServices();
    }

    /**
     * Get send message from the DCB.
     *
     * @return \Illuminate\Support\Collection
     */

    public function message($operator, $key, $data = [])
    {
        $this->operator = $operator;
        $message =  $this->formatMessage($key, $data);
        return $message;
    }


    public function handlingMessage($operator, $data = [])
    {
        return  $this->formatMessage($operator, $data);
    }

    /**
     * Get send message from the DCB.
     *
     * @return \Illuminate\Support\Collection
     */

    public function formatMessage($key, $data = [])
    {
        // Assuming $this->operator and FormatMessage::getMessage() work correctly
        $message = FormatMessage::getMessage($this->operator);
        $message = $message[$key]['en'];

        // Prepare the sprintf format string
        $formattedString = sprintf($message, ...$data);

        return $formattedString;
    }



    public function sendMessage($operator, $key, $info, $data = [])
    {

        $phone = $info["phone"];
        $user  = $info["user"];
        $message = $this->message($operator, $key, $data);
        if ($phone  !== null) {
            
            $this->DCBServices->sendMessage($operator, $phone,$message);
            
            return true;
        }

        if (isset($user['email'])) {
            $this->sendEmail($user['email'], $message);
            return true;
        }
        return false;
    }


    protected function sendEmail($email, $message) {
 
 
        // SendVoucherJob::dispatch($email, $message);

    }
}
