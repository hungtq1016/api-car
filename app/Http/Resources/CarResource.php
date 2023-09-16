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
        $diff_car = $this->user->ownerCars->filter(function ($car) {
            return $car->id != $this->id;
        });
        return [
            'id' => $this->id,
            'info' => [
                'name' => $this->car->name,
                'slug' => $this->car->slug,
                'seats'=>$this->car->seats,
                'fuel_type'=>$this->car->fuel_type,
                'fuel_consumption'=>$this->car->fuel_consumption,
                'transmission_type'=>$this->car->transmission_type,
                'features' => FeatureResource::collection($this->features),
                'isDelivery'=>$this->isDelivery,
                'total_trip'=>$this->guests->count(),
                'like_count'=>$this->likes->count(),
                'price'=>$this->price,
                'notes' => 'Quy định khác:
                ◦ Sử dụng xe đúng mục đích.
                ◦ Không sử dụng xe thuê vào mục đích phi pháp, trái pháp luật.
                ◦ Không sửa dụng xe thuê để cầm cố, thế chấp.
                ◦ Không hút thuốc, nhả kẹo cao su, xả rác trong xe.
                ◦ Không chở hàng quốc cấm dễ cháy nổ.
                ◦ Không chở hoa quả, thực phẩm nặng mùi trong xe.
                ◦ Khi trả xe, nếu xe bẩn hoặc có mùi trong xe, khách hàng vui lòng vệ sinh xe sạch sẽ hoặc gửi phụ thu phí vệ sinh xe.
                Trân trọng cảm ơn, chúc quý khách hàng có những chuyến đi tuyệt vời !',
                'rating'=>[
                    'total'=>$this->guests->count(),
                    'avg' => $this->guests()->avg('star'),
                    'star'=>[
                        '1'=>$this->guests()->where('star',1)->count(),
                        '2'=>$this->guests()->where('star',2)->count(),
                        '3'=>$this->guests()->where('star',3)->count(),
                        '4'=>$this->guests()->where('star',4)->count(),
                        '5'=>$this->guests()->where('star', 5)->count(),
                    ]
                ],
                'location'=>[
                    'province' => $this->province,
                    'district' => $this->district,
                ],
            ],
            
           
            'tab'=>[
                'desc' => $this->desc,
            ],
            'images'=>$this->images,
            'user'=>$this->user,
            'diff_car'=>$diff_car

        ];
        
    }
}
