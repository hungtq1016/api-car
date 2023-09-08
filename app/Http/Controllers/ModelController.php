<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\CarModel;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $models = CarModel::with('version')->get();
        $models = CarModel::all();

        // $models = CarModel::inRandomOrder()->with('cars')->with('image')->limit(50)->get();
        
        return response()->json([
            'code' => 200,
            'error' => false,
            'data'=> $models
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
            'year' => $arr[2],
            'model_id'=>$model->id
        ]);

        $version->model_id = $model->id;
        $version->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
