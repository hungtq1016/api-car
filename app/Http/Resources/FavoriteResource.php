<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->id,
            'name' => $this->car->name,
            'slug' => $this->car->slug,
            'price'=>$this->price,
            'fuel_type'=>$this->car->fuel_type,
            'transmission_type'=>$this->car->transmission_type,
            'image'=>$this->images->first(),
        ];
    }
}
