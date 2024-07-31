<?php

declare(strict_types=1);

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(
    basePath: dirname(__DIR__),
)->withRouting(
    web: __DIR__ . '/../routes/web/routes.php',
    api: __DIR__ . '/../routes/api/routes.php',
    commands: __DIR__ . '/../routes/console/routes.php',
    health: '/up',
)->withMiddleware(
    callback: function (Middleware $middleware): void {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    },
)->withExceptions(
    using: function (Exceptions $exceptions): void {},
)->create();
