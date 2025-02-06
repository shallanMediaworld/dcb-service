<?php

namespace App\src\Response;

interface ResponseSrc
{



    public  function __construct($key);

    public static function  __toArray();

    public  static function toJson();

    public function messages($sarch, $text);
}
