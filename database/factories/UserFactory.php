<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

final class UserFactory extends Factory
{
    /** @var class-string<Model> */
    protected $model = User::class;

    /** @return array<string,mixed> */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            'profile_photo_path' => null,
            'email_verified_at' => now(),
            'current_team_id' => null,
        ];
    }

    public function unverified(): UserFactory
    {
        return $this->state(
            state: fn (array $attributes): array => [
                'email_verified_at' => null,
            ],
        );
    }

    public function withPersonalTeam(?callable $callback = null): UserFactory
    {
        return $this->has(
            Team::factory()->state(fn (array $attributes, User $user) => [
                'name' => $this->faker->company(),
                'user_id' => $user->id,
                'personal_team' => true,
            ])->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
}
