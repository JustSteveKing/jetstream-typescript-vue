<?php

declare(strict_types=1);

namespace App\Actions\Jetstream;

use App\Models\Team;
use Laravel\Jetstream\Contracts\DeletesTeams;

final class DeleteTeam implements DeletesTeams
{
    public function delete(Team $team): void
    {
        $team->purge();
    }
}
