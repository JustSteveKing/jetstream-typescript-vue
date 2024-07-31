<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Team $resource */
final class TeamResource extends JsonResource
{
    /** @return array<string,mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'personal' => $this->resource->personal_team,
            'owner' => new UserResource(
                resource: $this->whenLoaded(
                    relationship: 'owner',
                ),
            ),
            'users' => UserResource::collection(
                resource: $this->whenLoaded(
                    relationship: 'users',
                ),
            ),
        ];
    }
}
