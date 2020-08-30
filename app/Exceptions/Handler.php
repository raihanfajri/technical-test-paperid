<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        $message = $exception->getMessage();
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\NotFoundHttpException)
        {
            return response(
                ['message' =>  empty($message) ? "Url not found!" : $message],
                $exception->getStatusCode()
            );
        }

        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException)
        {
            return response(
                ['message' => 'Method not allowed!'],
                $exception->getStatusCode()
            );
        }

        if ($exception instanceof \App\Exceptions\ValidationException)
        {
            return response(
                ['message' => $message],
                $exception->getStatusCode()
            );
        }

        return response(
            ['message' => $exception->getMessage()],
            500
        );
    }
}
