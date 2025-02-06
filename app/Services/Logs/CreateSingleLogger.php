<?php

namespace App\Services\Logs;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class CreateSingleLogger
{
    /**
     * Create a custom Monolog instance.
     *
     * @param  array  $config
     * @return \Monolog\Logger
     */
    public function __invoke(array $config)
    {
        $operator = $config['operator'] ?? 'default';
        $date = date('Y-m-d');
        $logDirectory = sprintf("%s/%s", rtrim($config['path'], '/'), $operator);
        $logPath = sprintf("%s/log-%s.log", $logDirectory, $date);

        if (!file_exists($logDirectory))
            mkdir($logDirectory, 0777, true);
        

        $logger = new Logger($config['name']);
        $logger->pushHandler(new StreamHandler($logPath, $config['level']));
        
        // Add context
        $logger->pushProcessor(function ($record) use ($operator) {
            $record['extra']['operator'] = $operator;
            return $record;
        });

        return $logger;
    }
}
