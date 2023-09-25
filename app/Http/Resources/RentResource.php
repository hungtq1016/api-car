<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id'=>$this->owner->id,
            'name' => $this->car->name,
            'slug' => $this->car->slug,
            'image'=>$this->owner->images->first(),
            'status' => $this->status,
            'start_day' => $this->start_day,
            'end_day' => $this->end_day,
            'address' => $this->address ,
            'total' => $this->total ,
        ];
    }
}
