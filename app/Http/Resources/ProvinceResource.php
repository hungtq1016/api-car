<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'type'=>$this->type,
            'image'=>$this->image,
            'car_count'=>$this->cars()->count(),
            'districts'=> DistrictResource::collection($this->whenLoaded('districts'))
        ];
    }
}
