<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class CopyResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'type' => 'copies',
            'id' => $this->id,
            'attributes' => [
                'rating'    => $this->rating,
                'completed' => $this->completed,
                'createdAt' => $this->created_at,
            ],
            'relationships' => [
                'owner'    => UserResource::make($this->owner()),
                'game'     => GameResource::make($this->game()),
                'platform' => PlatformResource::make($this->platform()),
            ],
            'links' => [
                'self'     => route('copies.show', $this->id),
                'owner'    => route('users.show', UserResource::make($this->owner())->id),
                'game'     => route('games.show', GameResource::make($this->game())->id),
                'platform' => route('platforms.show', PlatformResource::make($this->platform())->id),
            ],
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'success',
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('Accept', 'application/json');
    }
}
