<?php

namespace App\Http\Controllers;

use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use App\Traits\getImageFromURL;

class BrandController extends Controller
{
    use getImageFromURL;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //   $brands = Brand::through('models')->has('deployments')->get();
            // $brands = Brand::limit(10)->get();
        $brands = Brand::all();

        $brands = Brand::withCount('models')->orderBy('models_count', 'desc')->limit(10)->get();   
        // $brands = Brand::all();
        // foreach ($brands as $br) {
        //     if ($br->image_id == null) {
        //         $iiii = 'http://localhost:8001/model/'.$br->slug.'.png';
        //         $abc = $this->getImage($iiii, 'model');
        //         $br->image_id = $abc;
        //         $br->save();
        //     }
        // }
        return response()->json([
            'code' => 200,
            'error' => false,
            'data'=> BrandResource::collection($brands)
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        //
    }
}
