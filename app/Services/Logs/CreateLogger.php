<?php

namespace App\Services\Logs;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CreateLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $nameLog = $config['name'] ?? 'default';
 
        $date = date('Y-m-d');
        $logDirectory = sprintf("%s/%s", rtrim($config['path'], '/'), $nameLog);
        $logPath = sprintf("%s/log-%s.log", $logDirectory, $date);

        if (!file_exists($logDirectory))
            mkdir($logDirectory, 0777, true);
        

        $logger = new Logger($config['name']);
        $logger->pushHandler(new StreamHandler($logPath, $config['level']));
        
        // Add context
        $logger->pushProcessor(function ($record) use ($nameLog) {
            $record['extra']['name'] = $nameLog;
            return $record;
        });

        return $logger;
    }
}

