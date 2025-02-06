<?php

namespace App\src\Response;

class Response
{

    private static $messages, $default;

    public  function __construct($key)
    {
        self::$messages =  self::toJson();
        self::$messages =  collect(self::$messages[$key] ?? []);
        self::$default =  [
            "title" => "Error",
            "message" => "Message not found",
            "trans" => null,
            "successful"=>false,
        ];
    }

    public static function  __toArray()
    {

        return self::$messages->toArray();
    }

    public static  function toJson()
    {

        $collect = collect(json_decode(@file_get_contents(__DIR__ . '/message.json')));
        return $collect;
    }

    public function messages($sarch, $text)
    {

        $messages =  self::$messages->where($sarch, $text)->first();
 
        if ($messages === null)
            return self::$default;

        return self::$messages->where($sarch, $text)->first();
    }
}
