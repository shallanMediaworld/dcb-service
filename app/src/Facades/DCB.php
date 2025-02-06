<?php

namespace App\src\Facades;

use Illuminate\Support\Facades\Facade;
use App\src\DcbResponse;
use App\src\DCB\Zain;
use App\src\Contracts\DcbInterface;

/**
 * @method static DcbResponse response($status, $message, $data, ...$extraData)
 * @method static DcbResponse ok($message = null, $data = [], ...$extraData)
 * @method static DcbResponse notFound($message = null)
 * @method static DcbResponse validation($message = null, $errors = [], ...$extraData)
 *
 * @see DcbResponse
 * @see Zain
 */
class DCB extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    { 
        return DcbInterface::class;
    }
}
