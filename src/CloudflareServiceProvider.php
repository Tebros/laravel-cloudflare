<?php

namespace Adams\Cloudflare;

use Adams\Cloudflare\Middleware\TrustCloudflare;
use Illuminate\Support\ServiceProvider;

class CloudflareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Register middleware at the end of "$middleware"
        $kernel = $this->app['Illuminate\Contracts\Http\Kernel'];
        $kernel->pushMiddleware(TrustCloudflare::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\Reload::class,
                Commands\View::class
            ]);
        }
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}