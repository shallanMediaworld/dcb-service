<?php

namespace App\Services\Logs;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class LogsService
{

    public static function saveLogs($data = [])
    {
        activity()->causedBy(auth()->user())->withProperties($data)->log('Jizdan');
    }

    public static function logsOperator(string $action, string $operator = null, array $data = [])
    {
        $performedOn = $data['performedOn'] ?? auth()->user();

        $operator =  ($operator !== null)? $operator:"_NOTDEFINED_";
        
        unset($data['performedOn']);

        self::logWithOperator($operator, 'This is an emergency log', $data);

        activity()
            ->useLog("DCB Integration")
            ->performedOn($performedOn)
            ->causedBy(auth()->id())
            ->withProperties($data['data'])
            // ->batch(config('dcb.uuid')) 
            ->event($action)
            ->log($operator);
    }


    public static function logsCart(string $action,array $data = [] , $logName =null)
    {
        $performedOn = $data['performedOn'] ?? auth()->user();

        $logName = ($logName == null)  ? 'cart' : $logName ;
 
        $data['useLog'] =  $useLog = $data['data']['useLog'] ??  "DCB Integration";
        self::logFile($logName, $action,'This is an emergency log', $data);
        
        unset($data['performedOn'],$data['data']['useLog']);

        
        activity()
            ->useLog($useLog)
            ->performedOn($performedOn)
            ->causedBy(auth()->id())
            ->withProperties($data['data'])
            // ->batch(config('dcb.uuid')) 
            ->event($action)
            ->log($logName);
    }

    /**
     * Log a message with a dynamic operator.
     *
     * @param string $operator
     * @param string $message
     * @param array $data
     * @return void
     */
    private static function logWithOperator($operator, $message, $data = [])
    {
        $config = config('logging.channels.operator');
        $config['operator'] = $operator;
        $config['name'] = $operator;
        $logger = (new CreateSingleLogger())->__invoke($config);

        $logger->emergency("[User ID : " . auth()->id() . "] " . json_encode($data) . " " . $message);
    }



    /**
     * Log a message with a dynamic operator.
     *
     * @param string $operator
     * @param string $message
     * @param array $data
     * @return void
     */
    private static function logFile($logName,$action, $message, $data = [])
    {
        $config = config('logging.channels.users');
        $config['sublog'] = $logName;
        $config['name'] = $logName;
        $logger = (new CreateLogger())->__invoke($config);

        $logger->emergency("[action : " . $action . "]"  .$action. "[User ID : " . auth()->id() . "] " . json_encode($data) .  "[message : " . $message . "]".$message);
    }
}
