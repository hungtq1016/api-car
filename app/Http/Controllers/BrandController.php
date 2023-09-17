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

        $brands = Brand::withCount('models')->orderBy('models_count', 'desc')->has('models','>',0)->limit(20)->get();   
   
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
