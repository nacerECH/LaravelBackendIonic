<?php

namespace App\Http\Resources;

use App\Models\Restaurant;
use Illuminate\Http\Resources\Json\JsonResource;

class CommandeAccompagnantResource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->title,
            'prix' => $this->prix,
            'restaurant_id' => $this->restaurant_id,
            'pivot' => $this->pivot,
            // 'accompagnants' => AccompagnementResource::collection($this->accompagnements()->get()),
        ];
    }
}
