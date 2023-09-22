<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ThumbResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $location= $this->district == null ? $this->province->name:
        $this->district->name.', '.$this->province->name;
        return [
            'id' => $this->id,
            'info' => [
                'name' => $this->car->name,
                'slug' => $this->car->slug,
            ],
            'location' => [
                'district'=>$this->district,
                'province'=>$this->province,
            ],
            'isDelivery'=>$this->isDelivery,
            'price'=>$this->price,
            'seats'=>$this->car->seats,
            'fuel_type'=>$this->car->fuel_type,
            'transmission_type'=>$this->car->transmission_type,
            'total_trip'=>$this->guests->count(),
            'image'=>$this->images->first(),
            'like_count'=>$this->likes->count(),
            'review' => $this->guests()->avg('star'),
        ];
    }
}
