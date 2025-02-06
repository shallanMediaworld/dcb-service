<?php

namespace App\Services\Message;

class FormatMessage
{
    public static function getMessage($key)
    {
        $messages = include 'messages.php';
        return $messages[$key] ?? null;
    }
}
