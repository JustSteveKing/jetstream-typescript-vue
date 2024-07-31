<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\Workspace\Role;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

final class RoleServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        foreach (Role::cases() as $role) {
            Jetstream::role(
                key: $role->value,
                name: $role->name,
                permissions: $role->permissions(),
            )->description(
                description: $role->description(),
            );
        }
    }
}
