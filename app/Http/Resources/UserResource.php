<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public static $wrap = null;
    private $avatarEndpoint = '';

    /**
     * Transform the resource into an array.
     *
     * @param  string $avatarEndpoint
     * @return $this
     */
    public function setAvatarEndpoint(string $avatarEndpoint)
    {
        $this->avatarEndpoint = $avatarEndpoint;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'username' => $this->username ?? $this->name,
            'id'       => $this->id,
            'avatar'   => $this->avatarEndpoint . ($this->meta->avatar ?? $this->id),
        ];
    }
}
