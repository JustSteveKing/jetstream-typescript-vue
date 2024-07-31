<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

final class RateLimitServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        RateLimiter::for(
            name: 'login',
            callback: static fn (Request $request) => Limit::perMinute(
                maxAttempts: 5,
            )->by(
                key: Str::transliterate(
                    string: Str::lower(
                        value: $request->string(Fortify::username())->toString(),
                    ) . '|' . $request->ip(),
                ),
            ),
        );

        RateLimiter::for(
            name: 'two-factor',
            callback: static fn (Request $request) => Limit::perMinute(
                maxAttempts: 5,
            )->by(
                key: $request->session()->get('login.id'),
            ),
        );
    }
}
