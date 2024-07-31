<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

final class FortifyServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Fortify::createUsersUsing(
            callback: CreateNewUser::class,
        );
        Fortify::updateUserProfileInformationUsing(
            callback: UpdateUserProfileInformation::class,
        );
        Fortify::updateUserPasswordsUsing(
            callback: UpdateUserPassword::class,
        );
        Fortify::resetUserPasswordsUsing(
            callback: ResetUserPassword::class,
        );
    }
}
