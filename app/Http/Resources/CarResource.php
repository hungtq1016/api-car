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
        $cars = $this->car->brand->cars->filter(function ($car) {
            return $car->id != $this->id;
        })->slice(0, 4);
        return [
            'id' => $this->id,
            'relate'=>ThumbResource::collection($cars),
            'info' => [
                'name' => $this->car->name,
                'slug' => $this->car->slug,
                'seats'=>$this->car->seats,
                'fuel_type'=>$this->car->fuel_type,
                'fuel_consumption'=>$this->car->fuel_consumption,
                'transmission_type'=>$this->car->transmission_type,
                'features' => FeatureResource::collection($this->features),
                'isDelivery'=>$this->isDelivery,
                'delivery_fee'=>$this->delivery_fee,
                'isInstant'=>$this->isInstant,
                'isInsurance'=>$this->isInsurance,
                'total_trip'=>$this->guests->count(),
                'like_count'=>$this->likes->count(),
                'price'=>$this->price,
                'address'=>$this->address,
                'comment_count'=>$this->comments->count(),
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
            
           
            'tabs'=>[
                'desc' => $this->desc,
                'policies'=>[
                    'Thời Gian'=>['Trong vòng 2 giờ sau khi đặt','Trước 7 ngày sau khi đặt','Trong vòng 7 ngày sau khi đặt'],
                    'Khách Thuê'=>['<span class="text-green-600">Không mất cọc</span>','<span class="text-amber-600">Mất 50% cọc </span>','<span class="text-red-600">Mất 100% cọc</span>'],
                    'Chủ Xe'=>['<div class="text-green-600">Hoàn cọc 100%</div><div class="text-gray-600 text-xs">(Bị đánh giá 3 sao)</div>','<div class="text-amber-600">Hoàn cọc 100% (+50% giá trị cọc)</div><div class="text-gray-600 text-xs">(Bị đánh giá 2 sao)</div>','<div class="text-red-600">Hoàn cọc 100% (+100% giá trị cọc)</div><div class="text-gray-600 text-xs">(Bị đánh giá 1 sao)</div>']
                ],
                'comment_count'=>$this->comments->count(),
                'isMortgages'=>$this->isMortgages,
                'isIdentity'=>$this->isIdentity,
                'identity'=>['◦ GPLX & CCCD gắn chip (đối chiếu)','◦ GPLX (đối chiếu) & Passport (giữ lại)'],
                'mortgage'=>['Không cần thế chấp','◦ 15.000.000 ₫ (tiền mặt/chuyển khoản cho chủ xe khi nhận xe) hoặc Xe máy (kèm cà vẹt gốc) giá trị tương đương'],
                'user'=>[
                    'name'=>$this->user->name,
                    'email'=>$this->user->email,
                    'id'=>$this->user->id,
                    'star'=>$this->user->star->avg('star'),
                    'trip'=>$this->user->star->count(),
                ],           
            ],
            'images'=>$this->images,
        ];
        
    }
}
