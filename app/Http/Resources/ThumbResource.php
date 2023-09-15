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
        // $province = strval($this->province->name) ?? 'Chưa Có';
        // $location= "{$province}";
        return [
            'id' => $this->id,
            'info' => [
                'name' => $this->car->name,
                'slug' => $this->car->slug,
            ],
            
            'location' => $this->province->name,
            'isDelivery'=>$this->isDelivery,
            'price'=>$this->price,
            'seats'=>$this->car->seats,
            'fuel_type'=>$this->car->fuel_type,
            'transmission_type'=>$this->car->transmission_type,
            'total_trip'=>$this->guests->count(),
            'image'=>$this->images->first(),
            'total_review'=>$this->guests->count(),
            'review' => $this->guests()->avg('star'),
        ];
    }
}
