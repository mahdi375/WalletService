<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->bootRouteLimits();
        $this->bootApiRoutes();
        $this->bootWebRoutes();
    }
    
    private function bootRouteLimits(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    private function bootApiRoutes(): void
    {
        Route::prefix('api/v1')
            ->name('api.v1.')
            ->middleware('api')
            ->group(base_path('routes/v1/api.php'));
    }

    private function bootWebRoutes(): void
    {
        Route::name('web.')
            ->middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
