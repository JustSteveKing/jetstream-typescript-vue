<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Jetstream\Team as JetstreamTeam;

/**
 * @property string $id
 * @property string $name
 * @property bool $personal_team
 * @property string $user_id
 * @property null|CarbonInterface $created_at
 * @property null|CarbonInterface $updated_at
 * @property User $owner
 * @property Collection<User> $users
 */
final class Team extends JetstreamTeam
{
    use HasFactory;
    use HasUlids;

    /** @var array<int,string> */
    protected $fillable = [
        'name',
        'personal_team',
        'user_id',
    ];

    /** @return array<string,string> */
    protected function casts(): array
    {
        return [
            'personal_team' => 'boolean',
        ];
    }
}
