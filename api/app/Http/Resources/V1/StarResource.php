<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'face' => json_decode($this->face),
            'description' => $this->description,
            'popularity' => $this->popularity,
            'updated_at' => $this->updated_at->format('d/m/Y à H:i')
        ];
    }
}
