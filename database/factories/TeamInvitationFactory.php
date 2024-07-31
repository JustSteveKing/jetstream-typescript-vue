<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Team;
use App\Models\TeamInvitation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

final class TeamInvitationFactory extends Factory
{
    /** @var class-string<Model> */
    protected $model = TeamInvitation::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->companyEmail(),
            'role' => null,
            'team_id' => Team::factory(),
        ];
    }
}
