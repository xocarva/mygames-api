<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'type'  => 'games',
            'id'    => $this->id,
            'attributes'    => [
                'title'     => $this->title,
                'genreId'   => $this->genre_id,
                'studioId'  => $this->studio_id,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => [
                'genre' => GenreResource::make($this->genre()),
                'studio' => StudioResource::make($this->studio()),
            ],
        ];
    }

    public function with($request)
    {
        return [
            'status' => 'succes',
        ];
    }

    public function withResponse($request, $response)
    {
        $response->header('Accept', 'application/json');
        $response->header('Version', '1.0.0');
    }
}
