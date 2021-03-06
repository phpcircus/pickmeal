<?php

namespace App\Providers;

use App\Location\Here\HereApi;
use Illuminate\Support\ServiceProvider;

class HereServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(HereApi::class, function ($app) {
            $appId = config('here.app_id', '');
            $appCode = config('here.app_code', '');
            $headers = array_merge(config('here.headers', []), []);

            return new HereApi(['app_id' => $appId, 'app_code' => $appCode], $headers);
        });
    }
}
