<?php

namespace App\Http\Resources;

use App\Models\Menu;
use App\Models\Plat;
use App\Models\Client;
use App\Models\Restaurant;
use Illuminate\Support\Carbon;
use App\Http\Resources\MenuResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommandeAccompagnantResource;

class CommandeResource extends JsonResource
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
            'adresse' => $this->adresse,
            'telephone' => $this->telephone,
            'restaurant' => new RestaurantResource(Restaurant::find($this->restaurant_id)),
            'plat' => new PlatResource(Plat::find($this->plat_id)),
            'client' => new ClientResource(Client::find($this->client_id)),
            'total' => $this->total,
            'quantity' => $this->quantity,
            'accompagnants' => CommandeAccompagnantResource::collection($this->accompagnements()->get()),
            'date' => (new Carbon($this->created_at))->toDayDateTimeString()
        ];
    }
}
