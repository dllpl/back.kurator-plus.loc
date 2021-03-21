<?php

namespace App\Exceptions;

use Exception;
use GraphQL\Error\FormattedError;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Throwable;

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
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Exception $exception
     * @return Response
     * @throws Throwable
     */
    public function render($request, Exception $exception)
    {
        $result = parent::render($request, $exception);

        if (ltrim($request->getRequestUri(), '/') === config('lighthouse.route.uri') and
                !($exception instanceof GraphqlException)) {

            $error = FormattedError::createFromException($exception, false, $exception->getMessage());
            if ($exception instanceof AuthenticationException) {
                $error['extensions']['category'] = 'auth';
            }
            return response()->json([
                'errors' => [$error]
            ]);
        }

        return $result;
    }
}
