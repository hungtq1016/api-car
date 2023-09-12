<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarCollection;
use App\Http\Resources\CarResource;
use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Image;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cars = CarResource::collection(Car::inRandomOrder()->limit(8)->get());   
        return response()->json([
            'status_code'=>200,
            'error'=>false,
            'data'=>$cars
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
        $seats= $request->seats;
        $electric = $request->electric;
        $gear= $request->gear;
        $images = $request->images;
        // $arr = explode(' ',$carName);

        // Chia chuỗi thành các từ
        $arrName = explode(" ", strtolower($carName));
        // Lấy từ đầu tiên của mảng
        $first_word = $arrName[0];
        $last_word = $arrName[count($arrName) - 1];

        $fitst = array_shift($arrName);
        $last = array_pop($arrName);
        $mid =implode(" ", $arrName);
        $brand = Brand::firstOrCreate([
            'name' => ucfirst($first_word),
            'slug' =>Str::slug($first_word, '-'),
            'image_id'=>''
        ]);
        $model = CarModel::firstOrCreate([
            'name' => $mid,
            'slug' =>Str::slug($mid, '-'),
            'brand_id'=>$brand->id
        ]);

        // $model->brand_id = $brand->id;
        $model->save();

        $version = Version::firstOrCreate([
            'year' => is_integer($last_word) ? $last_word : intval($last_word),
            'model_id'=>$model->id
        ]);

        // $version->model_id = $model->id;
        $version->save();
        $car = Car::firstOrCreate([
            'name' => $carName,
            'slug'=>Str::slug($carName, '-'),
            'brand_id'=>$brand->id,
            'model_id'=>$model->id,
            'version_id'=>$version->id,
            'gear'=>$gear,
            'electric'=>$electric,
            'seats'=>$seats
        ]);
        foreach ($images as $image) {
            $contents = file_get_contents($image);
            $name = substr($image, strrpos($image, '/') + 1);
            $local = '/cars/'.Str::uuid().strrchr($name, '.');
             Storage::disk('public')->put($local, $contents);
            $host = request()->getHttpHost();
            $img = Image::create([
                'src'=>$host,
                'local_src'=>$local,
            ]);
            DB::table('car_image')->insert([
                'id'=>Str::uuid(),
                'car_id' => $car->id,
                'image_id' => $img->id
            ]);

        }
        return response()->json([
            'status_code'=>201,
            'error'=>false,
            'message'=>'Tải thành công',
            'tét'=>$name
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        return response()->json([
            'status_code' => 200,
            'error' => false,
            'message'=>'Thành công',
            'data' => new CarResource(Car::where('slug',$slug)->first())
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
