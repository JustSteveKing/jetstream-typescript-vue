<?php

declare(strict_types=1);

namespace App\Attributes;

use Attribute;

#[Attribute]
final class AsRole
{
    public function __construct(
        public string $name,
        public string $description,
        public array $permissions = [],
    ) {
    }
}
