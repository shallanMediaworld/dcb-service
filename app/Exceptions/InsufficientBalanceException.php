<?php

namespace App\Exceptions;

use Exception;

class InsufficientBalanceException extends Exception
{
               // You can customize the exception message and code here
               public function __construct($message = "Insufficient balance", $code = 0, Exception $previous = null)
               {
                   
                              logInfo(__FUNCTION__, ["message" => $message, "code" => $code], "InsufficientBalance");
 
                              parent::__construct($message, $code, $previous);
               }
 
}
