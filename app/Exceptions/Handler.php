<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use InvalidArgumentException;

class Handler extends ExceptionHandler
{


    public function render($request, Throwable $exception)
    {
        // dd($exception instanceof ModelNotFoundException,  $exception);
        if ($exception instanceof AuthenticationException)
            return respondUnauthorized('Unauthorized');  
        if($exception instanceof ThrottleRequestsException) 
             return respondTooManyRequest('Too Many Requests');  
        if ($exception instanceof UnauthorizedHttpException)
            return respondUnauthorized('Unauthorized');
        if ($exception instanceof RouteNotFoundException) 
            return respondNotFound('Not Found');
        if ($exception instanceof MethodNotAllowedHttpException) 
            return respondMethodAllowed('Method Not Allowed');
        if ($exception instanceof NotFoundHttpException)
            return respondNotFound('Not Found');
        if ($exception instanceof ModelNotFoundException){
 
            $resp = str_replace('App\\Models\\', '', $exception->getMessage());
 
            return respondModelNotFound("Model {$resp} Not found" );
        }

         // Handle InvalidArgumentException for unknown operator
         if ($exception instanceof InvalidArgumentException) {
            return respondInvalidArgument("Unknown operator: {$exception->getMessage()}");
        }

        if ($exception instanceof InsufficientBalanceException) {
            return respondInsufficientBalance("Insufficient balance");
        }
        return parent::render($request, $exception);
    }
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
