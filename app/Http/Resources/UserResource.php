<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read User $resource */
final class UserResource extends JsonResource
{
    /** @return array<string,mixed> */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'avatar' => $this->resource->profile_photo_path,
            'verified' => null !== $this->resource->email_verified_at,
            'team' => new TeamResource(
                resource: $this->resource->currentTeam,
            ),
            'teams' => TeamResource::collection(
                resource: $this->whenLoaded(
                    relationship: 'teams',
                ),
            ),
        ];
    }
}
