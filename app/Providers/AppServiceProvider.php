<?php

namespace App\Providers;

use App\Services\Logs\LogsService;
use Illuminate\Support\ServiceProvider;
use Config;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LogsService::class, function ($app) {
            return new LogsService();
        });
        Config::set('requestheaders', require config_path('requestheaders.php'));

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Validator::extend('valid_link', function ($attribute, $value, $parameters, $validator) {
            return filter_var($value, FILTER_VALIDATE_URL) !== false;
        });
        Paginator::useBootstrap();
    }
}
