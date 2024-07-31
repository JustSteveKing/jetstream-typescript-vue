<?php

declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;
use Laravel\Sanctum\PersonalAccessToken;

final class DeleteUser implements DeletesUsers
{
    public function __construct(
        protected DeletesTeams $deletesTeams,
    ) {
    }

    public function delete(User $user): void
    {
        DB::transaction(function () use ($user): void {
            $this->deleteTeams($user);
            $user->deleteProfilePhoto();
            $user->tokens->each(
                callback: fn (PersonalAccessToken $token) => $token->delete(),
            );
            $user->delete();
        });
    }

    private function deleteTeams(User $user): void
    {
        $user->teams()->detach();

        $user->ownedTeams->each(function (Team $team): void {
            $this->deletesTeams->delete($team);
        });
    }
}
