<?php

declare(strict_types=1);

namespace App\Enums\Workspace;

use App\Attributes\AsRole;
use ReflectionAttribute;
use ReflectionEnumUnitCase;

enum Role: string
{
    #[AsRole(
        name: 'admin',
        description: 'Administrative user.',
        permissions: [
            'create','read','update','delete',
        ],
    )]
    case Admin = 'admin';

    #[AsRole(
        name: 'member',
        description: 'Member of the workspace.',
        permissions: [
            'create','read','update',
        ],
    )]
    case Member = 'member';

    public function description(): string
    {
        return $this->attributes()[0]?->newInstance()->description;
    }

    public function permissions(): array
    {
        return $this->attributes()[0]?->newInstance()->permissions;
    }

    /** @return array<int,ReflectionAttribute> */
    private function attributes(): array
    {
        return (new ReflectionEnumUnitCase(
            class: $this,
            constant: $this->name,
        ))->getAttributes(
            name: AsRole::class,
        );
    }
}
