<?php

declare(strict_types=1);

namespace App\Observers;

use App\Enums\Workspace\Role;
use App\Models\Team;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

final class TeamObserver implements ShouldQueue
{
    use InteractsWithQueue;

    public function created(Team $team): void
    {
        $team->owner()->update(
            values: [
                'current_team_id' => $team->id,
            ],
        );

        $team->users()->attach($team->user_id, ['role' => Role::Admin]);
    }
}
