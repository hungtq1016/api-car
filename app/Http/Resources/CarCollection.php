<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'seats' => $this->seats,
            'gear' => $this->gear,
            'electric' => $this->electric,
            'brand'=>$this->brand,
            'images'=>$this->images,
            'transmission'=>1,
            'isDelivery'=>1
        ];
    }
}
