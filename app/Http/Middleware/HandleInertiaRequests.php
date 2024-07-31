<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Resources\UserResource;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\Request;
use Inertia\Middleware;

final class HandleInertiaRequests extends Middleware
{
    public function __construct(
        private readonly AuthManager $auth,
    ) {
    }

    /** @return array<string,mixed> */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $this->auth->check() ? new UserResource(
                    resource: $this->auth->user()?->load(['currentTeam']),
                ) : null,
            ],
            'route' => [
                'name' => $request->route()?->getName(),
            ],
        ]);
    }
}
