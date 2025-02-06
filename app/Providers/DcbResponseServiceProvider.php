<?php

namespace App\Providers;

use App\src\DcbResponse;
use Illuminate\Support\ServiceProvider;
use App\src\Contracts\DcbInterface;
use App\src\DCB\Zain;
use Throwable;
use Illuminate\Support\Facades\Config;

class DcbResponseServiceProvider extends ServiceProvider
{



    /**
     * RegisterCompany API class.
     *
     * @return void
     */
    public function register()
    {
        //     $class =  collect(config("dcb.operators"))->pluck('class');

        //     // Assuming you're in a class method or constructor
        //     $class = collect(config("dcb.operators"))->map(function ($item, $key) {
        //         return [$key => new $item['class']];
        //     })->collapse();


        //    $class =  $class->merge(["default" => new DcbResponse()]);

        //     $this->app->bind(DcbInterface::class, function () use ($class){
        //         return $class;
        //     });

        $this->app->bind(DcbInterface::class, function ($app, $parameters) {
            return new DcbResponse();
        });
    }



    /**
     * Bootstrap API resources.
     *
     * @return void
     */
    public function boot()
    {
        $this->setupConfig();

        $this->registerHelpers();

        $this->publishes([
            __DIR__ . '/../config/dcb.php' => config_path('dcb.php'),
        ], 'api-response');

        $dcbAvailable = $this->fetchDcbAvailable();

        // Set the configuration value
        Config::set('channel.dcb_available', $dcbAvailable);
        Config::set('channel.alias_name', array_merge($dcbAvailable, config('channel.alias_name')));
    }

    private function fetchDcbAvailable(): array
    {
        try {
            $dcb = app(DcbInterface::class);
            return $dcb->operatorAvailable() ?: []; // Ensure it defaults to an array
        } catch (Throwable $e) {
            // Handle exceptions and return an empty array
            return [];
        }
    }
    /**
     * Set Config files.
     */
    protected function setupConfig()
    {
        $path = realpath($raw = __DIR__ . '/../../config/dcb.php') ?: $raw;
        $this->mergeConfigFrom($path, 'api');
    }

    /**
     * RegisterCompany helpers.
     */
    protected function registerHelpers()
    {
        if (file_exists($helperFile = __DIR__ . '/../Src/helpers.php')) {
            require_once $helperFile;
        }
    }
}
