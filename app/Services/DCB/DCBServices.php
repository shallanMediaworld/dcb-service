<?php

namespace App\Services\DCB;

use App\Services\Message\MessageServices;

class DCBServices
{
   private $messageServices;

   public function  __construct(){
 
   
      // $this->messageServices =  new MessageServices();

   }

   public function cehckLimit($operator, $quantity)
   {

      return cehckLimit($operator, $quantity);
   }
 
   public function sendOtp($data, $group_id, $pricepointId, $app_id)
   {
      extract($data);

 
      $app_id = $app_id . '_' . $pricepointId;

      return   sendOtp($operator, $phone, $price, ['app_id' => $app_id]);
   }

   public function  sendMessage($operator, $phone, $message)
   {     
       sendMessage($operator, $phone,$message);
       
   }
}
