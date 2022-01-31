<?php

namespace App\Http\Resources;

use App\Models\Restaurant;
use Illuminate\Http\Resources\Json\JsonResource;

class ReclamationResource extends JsonResource
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
            'sujet' => $this->sujet,
            'description' => $this->description,
            'reclamationable' => ($this->reclamationable()->first() instanceof Restaurant) ? new RestaurantResource($this->likeable()->first())  : new ClientResource($this->likeable()->first())
        ];
    }
}
