<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Middleware\ThrottleRequests;

class Throttle extends ThrottleRequests
{
    /** @var string */
    protected $slug;

    /**
     * Handle the Throttle middleware.
     *
     * @param  mixed  $request
     * @param  \Closure  $next
     * @param  int  $maxAttempts
     * @param  int  $decayMinutes
     * @param  mixed  $slug
     */
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $slug = null): Response
    {
        $this->slug = $slug;

        return parent::handle($request, $next, $maxAttempts, $decayMinutes);
    }

    /**
     * Resolve request signature.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @throws \RuntimeException
     */
    protected function resolveRequestSignature($request): string
    {
        if (! $route = $request->route()) {
            throw new RuntimeException('Unable to generate the request signature. Route unavailable.');
        }

        // With a provided identifier we can throttle a group of routes, so that all the routes in the group
        // will have the same throttle signature.
        if ($this->slug) {
            return $this->generateGroupSignature($request);
        }

        return $this->generateRouteSignature($request, $route);
    }

    /**
     * Generate signature for a group of routes.
     *
     * @param  mixed  $request
     */
    protected function generateGroupSignature($request): string
    {
        $identifier = ($user = $request->user())
            ? $user->getAuthIdentifier()
            : $request->ip();

        return sha1($this->slug . '|' . $identifier);
    }

    /**
     * Generate signature for an individual route.
     *
     * @param  mixed  $request
     */
    protected function generateRouteSignature($request, $route): string
    {
        if ($user = $request->user()) {
            return sha1(implode('|', array_merge(
                $route->methods(),
                [$route->getDomain(), $route->uri(), $user->getAuthIdentifier()]
            )));
        }

        return $request->fingerprint();
    }
}
