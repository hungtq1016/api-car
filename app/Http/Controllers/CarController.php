<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Car;
use App\Models\CarModel;
use App\Models\Image;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $arr = explode(' ',$carName);
        $brand = Brand::firstOrCreate([
            'name' => $arr[0],
            'slug' =>Str::slug($arr[0], '-'),
            'image_id'=>''
        ]);

        $model = CarModel::firstOrCreate([
            'name' => $arr[1],
            'slug' =>Str::slug($arr[0], '-'),
            'brand_id'=>$brand->id
        ]);

        // $model->brand_id = $brand->id;
        $model->save();

        $version = Version::firstOrCreate([
            'year' => is_integer($arr[2]) ? $arr[2] : null,
            'model_id'=>$model->id
        ]);

        // $version->model_id = $model->id;
        $version->save();
        $car = Car::create([
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
            // $url = "http://www.google.co.in/intl/en_com/images/srpr/logo1w.png";
            $contents = file_get_contents($image);
            $name = substr($image, strrpos($image, '/') + 1);
            $local = '/cars/'.$name;
             Storage::disk('public')->put($local, $contents);
            
            // $info = pathinfo($image);
            // $contents = file_get_contents($image);
            // $file = '/cars/' . $info['basename'];
            // file_put_contents($file, $contents);
            // $uploaded_file = new UploadedFile($file, $info['basename']);
            $img = Image::create([
                'src'=>$image,
                'local_src'=>$local,
            ]);
            DB::table('car_image')->insert([
                'id'=>Str::uuid(),
                'car_id' => $car->id,
                'image_id' => $img->id
            ]);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
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
