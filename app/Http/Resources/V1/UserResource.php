<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'type' => 'users',
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'admin' => $this->admin,
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
