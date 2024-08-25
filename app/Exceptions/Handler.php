<?php

namespace PractiCampoUD\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;

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
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        
        if ($this->isHttpException($exception)) {
            switch ($exception->getStatusCode()) {
    
                // not authorized
                case '403':
                    return \Response::view('errors.403',array(),403);
                    break;
    
                // not found
                case '404':
                    return \Response::view('errors.404',array(),404);
                    break;
    
                // internal error
                case '500':
                    return \Response::view('errors.500',array(),500);
                    break;
    
                // internal error
                case '999':
                    // if ($exception instanceof TokenMismatchException) {
                    //     return redirect()->route('login');
                    // }
                    return redirect()->route('loginEst');
                    break;

                default:
                    return $this->renderHttpException($exception);
                    break;
            }
        } else 
        {
            return parent::render($request, $exception);
        }
    }
}
