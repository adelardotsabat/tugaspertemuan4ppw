<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        RateLimiter::for('portfolio-api', fn (Request $r) =>
            Limit::perMinute(60)->by($r->ip())
        );

        RateLimiter::for('contact', fn (Request $r) =>
            Limit::perMinute(3)->by($r->ip())
        );
    }
}