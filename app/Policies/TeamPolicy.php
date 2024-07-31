<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

final class TeamPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Team $team): bool
    {
        return $user->belongsToTeam(
            team: $team,
        );
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Team $team): bool
    {
        return $user->ownsTeam(
            team: $team,
        );
    }

    public function addTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam(
            team: $team,
        );
    }

    public function updateTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam(
            team: $team,
        );
    }

    public function removeTeamMember(User $user, Team $team): bool
    {
        return $user->ownsTeam(
            team: $team,
        );
    }

    public function delete(User $user, Team $team): bool
    {
        return $user->ownsTeam(
            team: $team,
        );
    }
}
