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
use App\Models\Version;
use App\Traits\getImageFromURL;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\CommentController;
use App\Http\Resources\ThumbResource;

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
        $desc = $request->desc;
        $notes = $request->notes;
        $transmission_type = $request->transmission_type;
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
        $price = $request->price;
        $location = str_replace(', ', ',', $location);
        $locate = explode(',', $location);
        $locate = array_reverse($locate);
        $fs = [];
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
            array_push($fs, $f->id);
        }
        // Chia chuỗi thành các từ
        $names = strtolower($carName);
        $arrName = explode(" ", $names);
        // Lấy từ đầu tiên của mảng
        $first_word = $arrName[0];
        $last_word = $arrName[count($arrName) - 1];

        $fitst = array_shift($arrName);
        $last = array_pop($arrName);
        $mid = implode(" ", $arrName);
        $brand = Brand::firstOrCreate([
            'name' => ucfirst($first_word),
            'slug' => Str::slug($first_word, '-'),
            'image_id' => ''
        ]);
        $model = CarModel::firstOrCreate([
            'name' => $mid,
            'slug' => Str::slug($mid, '-'),
            'brand_id' => $brand->id
        ]);

        // $model->brand_id = $brand->id;
        $model->save();

        $version = Version::firstOrCreate([
            'year' => is_integer($last_word) ? $last_word : intval($last_word),
            'model_id' => $model->id
        ]);

        // $version->model_id = $model->id;
        $version->save();
        $car = Car::firstOrCreate([
            'name' => $names,
            'slug' => Str::slug($names, '-'),
            'brand_id' => $brand->id,
            'model_id' => $model->id,
            'version_id' => $version->id,
            'fuel_type' => $fuel_type,
            'fuel_consumption' => $fuel_consumption,
            'transmission_type' => $transmission_type&&-1,
            'seats' => $seats
        ]);

        $user = User::inRandomOrder()->first();
        $dis = District::where('name', $locate[1])->first();
        $pro = Province::where('name', $locate[0] == 'Hồ Chí Minh' ? 'Thành phố Hồ Chí Minh' : $locate[0])->first();
        $owner = Owner::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'notes' => $notes,
            'car_id' => $car->id,
            'province_id' => $pro->id ?? null,
            'district_id' => $dis->id ?? null,
            'isDelivery' => $isDelivery,
            'desc' => $desc,
            'price' => $price,
        ]);
        $is = [];
        foreach ($images as $image) {
            $imageId = $this->getImage($image, 'cars');
            array_push($is, $imageId);
        }
        $randGuest = rand(10,100);
        for ($i=0; $i < $randGuest; $i++) { 
            $guest = User::inRandomOrder()->first();
            $owner->guests()->attach($guest,['star'=>random_number()]);
        }
        $owner->features()->attach($fs);
        $owner->images()->attach($is);

        $randCmt = rand(10,50);
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
      
        return response()->json([
            'status_code' => 201,
            'error' => false,
            'message' => 'Tải thành công',
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
