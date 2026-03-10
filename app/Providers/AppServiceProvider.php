<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ── HTTPS en production ──
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            DB::prohibitDestructiveCommands();
        }

        // ── Sécurité Eloquent ──
        Model::shouldBeStrict(! $this->app->isProduction());

        // ── Rate limiters ──
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('ussd', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip());
        });
    }
}
