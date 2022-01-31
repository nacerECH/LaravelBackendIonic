<?php

namespace App\Http\Resources;

use App\Models\Restaurant;
use App\Http\Resources\RestaurantResource;
use App\Http\Resources\AccompagnementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PlatResource extends JsonResource
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
            'restaurant_id' => $this->restaurant_id,
            'restaurant' => new RestaurantResource($this->restaurant),
            'menu_id' => $this->menu_id,
            'nom' => $this->title,
            'description' => $this->description,
            'price' => $this->prix,
            'promoPrice' => $this->prix_promo,
            'isPromo' => $this->is_promo,
            'images' => ImageResource::collection($this->images()->get()),
            'accompagnants' => AccompagnementResource::collection($this->accompagnements()->get()),
        ];
    }
}
