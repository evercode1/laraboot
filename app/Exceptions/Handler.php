<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Exceptions\NoActiveAccountException;
use App\Exceptions\AlreadySyncedException;
use App\Exceptions\ConnectionNotAcceptedException;
use App\Exceptions\CredentialsDoNotMatchException;
use App\Exceptions\EmailAlreadyInSystemException;
use App\Exceptions\EmailNotProvidedException;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        switch($e){

            case ($e instanceof AlreadySyncedException):
                return $this->renderException($e);
                break;

            case ($e instanceof ConnectionNotAcceptedException):
                return $this->renderException($e);
                break;

            case ($e instanceof CredentialsDoNotMatchException):
                return $this->renderException($e);
                break;

            case ($e instanceof EmailAlreadyInSystemException):
                return $this->renderException($e);
                break;

            case ($e instanceof EmailNotProvidedException):
                return $this->renderException($e);
                break;

            case ($e instanceof ModelNotFoundException):

                return $this->renderException($e);
                break;

            case ($e instanceof NoActiveAccountException):

                return $this->renderException($e);
                break;

            case ($e instanceof NotFoundHttpException):

                return $this->renderException($e);
                break;

            case ($e instanceof UnauthorizedException):

                return $this->renderException($e);
                break;

            default:

                return parent::render($request, $e);

        }
    }

    protected function renderException($e)
    {

        switch ($e){

            case ($e instanceof AlreadySyncedException):
                return response()->view('errors.already-synced');
                break;

            case ($e instanceof ConnectionNotAcceptedException):
                return response()->view('errors.connection-not-accepted');
                break;

            case ($e instanceof CredentialsDoNotMatchException):
                return response()->view('errors.credentials-do-not-match');
                break;

            case ($e instanceof EmailAlreadyInSystemException):
                return response()->view('errors.email-already-in-system');
                break;

            case ($e instanceof EmailNotProvidedException):
                return response()->view('errors.email-not-provided');
                break;

            case ($e instanceof ModelNotFoundException):
                return response()->view('errors.404', [], 404);
                break;

            case ($e instanceof NoActiveAccountException):
                return response()->view('errors.no-active-account');
                break;

            case ($e instanceof NotFoundHttpException):

                return response()->view('errors.404', [], 404);
                break;

            case ($e instanceof UnauthorizedException):
                return response()->view('errors.unauthorized');
                break;

            default:
                return (new SymfonyDisplayer(config('app.debug')))
                    ->createResponse($e);

        }

    }
}
