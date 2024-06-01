<?php

namespace App\Http\Resources;

use App\Models\Room;
use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
{
    private $resource;

    public function __construct(Room $resource) {
        $this->resource = $resource;
    }

    public function toArray($resource)
    {
        $owner = $this->resource->owner();
        $messages = $this->resource->messages();

        return [
            "room" => $this->resource,
            "owner" => $owner,
            "messages" => $messages
        ];
    }
}
