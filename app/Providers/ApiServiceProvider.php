<?php

namespace App\Providers;

use App\Exceptions\ApiHandler;
use App\Http\Controllers\AuthController;
use App\Http\Responses\ApiResponder;
use App\Http\Responses\ResponsesInterface;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Http\Controllers\AccessTokenController;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Number of items per page in each collection.
     *
     * @var int
     */
    public static $itemsPerPage = 25;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Use the ApiResponder as the concrete implementation for the ResponsesInterface
        $this->app->bind(ResponsesInterface::class, ApiResponder::class);
        // Use the ApiHandler as the main exception handler
        $this->app->singleton(ExceptionHandler::class, ApiHandler::class);
    }
}
