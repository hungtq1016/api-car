<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'info' => [
                'name' => $this->car->name,
                'slug' => $this->car->slug,
            ],
            'rating'=>[
                '1'=>$this->guests()->where('star',1)->count(),
                '2'=>$this->guests()->where('star',2)->count(),
                '3'=>$this->guests()->where('star',3)->count(),
                '4'=>$this->guests()->where('star',4)->count(),
                '5'=>$this->guests()->where('star', 5)->count(),
            ],
            'province' => $this->province,
            'district' => $this->district,
            'isDelivery'=>$this->isDelivery,
            'price'=>$this->price,
            'seats'=>$this->car->seats,
            'fuel_type'=>$this->car->fuel_type,
            'transmission_type'=>$this->car->transmission_type,
            'total_trip'=>$this->guests->count(),
            'images'=>$this->images,
            'total_review'=>$this->guests->count(),
            'review' => $this->guests()->avg('star'),
        ];
        
    }
}
