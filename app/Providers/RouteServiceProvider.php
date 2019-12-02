<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to your action routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $actionNamespace = 'App\Http\Actions';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        $this->mapActionWebRoutes();

        $this->mapActionApiRoutes();
    }

    /**
     * Define the "action" routes for the web application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapActionWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->actionNamespace)
            ->group(base_path('routes/actions.php'));
    }

    /**
     * Define the "action" routes for the api.
     *
     * These routes do not receive session state, CSRF protection, etc.
     */
    protected function mapActionApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->actionNamespace)
            ->group(base_path('routes/actions_api.php'));
    }
}
