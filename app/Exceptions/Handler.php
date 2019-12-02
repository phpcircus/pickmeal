<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use App\Services\Meal\Exceptions\InvalidLocationId;
use App\Services\Meal\Exceptions\InvalidCustomAddress;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
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
        $response = parent::render($request, $exception);

        if ($exception instanceof InvalidCustomAddress) {
            if ($request->isApi()) {
                return response()->json([
                    'message' => 'Custom address is invalid or incomplete. Please try again.',
                ], 422);
            }

            flash('warning', 'Custom address is invalid or incomplete. Please try again.');

            return redirect()->route('home');
        }

        if ($exception instanceof InvalidLocationId) {
            if ($request->isApi()) {
                return response()->json([
                    'message' => 'Unable to determine current location. Please try again.',
                ], 422);
            }

            flash('warning', 'Unable to determine current location. Please try again.');
            return redirect()->route('home');
        }

        if ($exception instanceof ThrottleRequestsException) {
            if ($request->isApi()) {
                return response()->json([
                    'errors' => [
                        'throttle' => [
                            'You have exceeded the number of allowed requests. Please wait 1 minute.',
                        ],
                    ],
                ], 422);
            }

            flash('warning', 'You have exceeded the number of allowed requests. Please wait 1 minute.');
            return redirect()->route('home');
        }

        if ($request->header('X-Inertia')) {
            if (in_array($response->status(), [500, 503, 404, 403])) {
                flash('warning', 'Something went wrong.');
            }

            if ($this->csrfExpired($response)) {
                flash('info', "The session expired so we've refreshed the page. You may now try again!");
            }

            return redirect()->route('home');
        }

        if ($exception instanceof AuthorizationException) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized.'], 403);
            }

            flash('warning', 'Something went wrong.');

            return redirect()->route('home');
        }

        return $response;
    }

    /**
     * Check if the csrf token has expired.
     *
     * @param  \Symfony\Component\HttpFoundation\Response  $response
     */
    private function csrfExpired($response): bool
    {
        return $response->status() === 419;
    }
}
