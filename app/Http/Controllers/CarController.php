<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarResource;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\District;
use App\Models\Feature;
use App\Models\Owner;
use App\Models\Province;
use App\Models\User;
use App\Traits\getImageFromURL;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\CommentController;
use App\Http\Resources\ThumbResource;
use App\Models\Comment;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use getImageFromURL;

    public function index(Request $request)
    {
        $cars = Owner::inRandomOrder()->limit(8)->get();
        // $cars = CarResource::collection(Car::inRandomOrder()->limit(8)->get());   
        return response()->json([
            'status_code' => 200,
            'error' => false,
            'data' => ThumbResource::collection($cars)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $carName = $request->car_name;
        $seats = $request->seats;
        $fuel_consumption = $request->fuel_consumption;
        $fuel_type = $request->fuel_type;
        $features = $request->features;
        $images = $request->images;
        $location = $request->location;;
        $isDelivery = $request->isDelivery;
        $isInstant = $request->isInstant;
        $isMortgages = $request->isMortgages;
        $address = $request->address;
        $desc = $request->desc;
        $transmission_type = $request->transmission_type;
        $price = $request->price;

        function random_number() {
            $random_value = rand(1, 100);
            if ($random_value>0 && $random_value<=2) {
                return 1;
            }
            if ($random_value>2 && $random_value<=5) {
                return 2;
            }
            if ($random_value>5 && $random_value<=15) {
                return 3;
            }
            if ($random_value>15 && $random_value<=30) {
                return 4;
            }
            if ($random_value>30 && $random_value<=100) {
                return 5;
            }
          }
        $location = str_replace(', ', ',', $location);
        $locate = explode(',', $location);
        $locate = array_reverse($locate);

        $featureArray = [];
        foreach ($features as $feature) {
            $f = Feature::firstOrCreate([
                'name' => $feature['name'],
                'slug' => Str::slug($feature['name'], '-'),
            ]);
            if ($f->image_id == null) {
                $id = $this->getImage($feature['logo'], 'logo');
                $f->image_id = $id;
                $f->save();
            }
            array_push($featureArray, $f->id);
        }
        // Chia chuỗi thành các từ
        $carName = strtolower($carName);
        $car_name = $carName;
        $arrName = explode(" ", $carName);
        // Lấy từ đầu tiên của mảng
        $brand_name = '';
        $twowordbrands= ['morris garages','aston martin'];
        $is2Words = array_search($arrName[0].' '.$arrName[1],$twowordbrands);
        if ($is2Words) {
            $brand_name = $arrName[0].' '.$arrName[1];
        }else{
            $brand_name = $arrName[0];
        }
        $model_name = str_replace($brand_name,'',$carName);
        
        $findProvince = Province::where('name', $locate[0])->first();
        $tolower =  Str::slug($locate[0],'-');
        if ($findProvince->image_id == null) {
            $imgpro = 'http://localhost:8001/provinces/'.$tolower.'.jpg';
            $impro = $this->getImage($imgpro, 'provinces');
            $findProvince->image_id = $impro;
            $findProvince->save();
        }
        
       
        $brand = Brand::firstOrCreate([
            'name' => $brand_name,
            'slug' => Str::slug($brand_name, '-'),
        ]);
        if ($brand->image_id == null) {
            $img = 'http://localhost:8001/model/'.Str::slug($brand_name, '-').'.png';
            $idimgbrand = $this->getImage($img, 'model');
            $brand->image_id = $idimgbrand;
            $brand->save();
        }
        $model = CarModel::firstOrCreate([
            'name' => $model_name,
            'slug' => Str::slug($model_name, '-'),
            'brand_id' => $brand->id
        ]);

        $car = Car::firstOrCreate([
            'name' => $car_name,
            'slug' => Str::slug($car_name, '-'),
            'seats' => $seats,
            'brand_id' => $brand->id,
            'model_id' => $model->id,
            'fuel_consumption' => $fuel_consumption,
            'fuel_type' => $fuel_type,
            'transmission_type' => $transmission_type,
        ]);

        $user = User::inRandomOrder()->first();
        $dis = District::where('name', $locate[1])->first();
        $pro = Province::where('name', $locate[0])->first();

        $owner = Owner::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'car_id' => $car->id,
            'province_id' => $pro->id ?? null,
            'district_id' => $dis->id ?? null,
            'isDelivery' => $isDelivery,
            'desc' => $desc,
            'price' => $price,
            'isInstant' =>$isInstant,
            'isMortgages' =>$isMortgages,
            'address' =>$address,
        ]);

        $imageArray = [];
        foreach ($images as $image) {
            $imageId = $this->getImage($image, 'cars');
            array_push($imageArray, $imageId);
        }
        $randGuest = rand(10,100);
        for ($i=0; $i < $randGuest; $i++) { 
            $guest = User::inRandomOrder()->first();
            $star= random_number();
            if ($star == 5) {
                $owner->likes()->attach($guest);
            }
            $owner->guests()->attach($guest,['star'=>$star]);
        }
        $owner->features()->attach($featureArray);
        $owner->images()->attach($imageArray);

        $randCmt = rand(10,20);
        $randLike = rand(20,50);
        $parentId = null;
        $result = '';
        $parentArr=[];
        for ($i=0; $i < $randCmt; $i++) { 
            $us = User::inRandomOrder()->first();

            $result = (new CommentController)->store([
                'post_id'=>$owner->id,
                'user_id'=>$us->id,
                'content'=>fake()->realText(rand(10,50)),
                'parent_id'=>rand(0,1)?null:($parentId==null?null:$parentArr[rand(0,count($parentArr)-1)])
            ]);
            $parentId =strval($result->original['message'][0]['id']);
            array_push($parentArr,$parentId);  
        }
        for ($i=0; $i < $randLike; $i++) { 
            $usr = User::inRandomOrder()->first();
            $cmt = Comment::inRandomOrder()->first();
            $cmt->likes()->syncWithoutDetaching($usr);

        }
      
        return response()->json([
            'status_code' => 201,
            'error' => false,
            'message' => $tolower,
            'data'=>$findProvince
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json([
            'status_code' => 200,
            'error' => false,
            'message' => 'Thành công',
            'data' => new CarResource(Owner::findOrFail($id))
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        //
    }
    
}
