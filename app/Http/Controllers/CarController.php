<?php

namespace App\Http\Controllers;

use App\Http\Resources\CarResource;
use App\Models\Car;
use App\Models\Owner;
use Illuminate\Http\Request;
use App\Http\Resources\ThumbResource;
use App\Models\Brand;
use DateTime;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $query = Owner::query();
        if ($request->has('brand') && $request->brand != 'all') {
            $condition = $request->brand;
            $query->withWhereHas('brand', function ($query) use ($condition) {
                $query->where('brands.name', $condition);
            });
        }
        if ($request->has('priceStar')||$request->has('priceEnd')) {
            $condition1 = $request->priceStar ?? 0;
            $condition2 = $request->priceEnd ?? 10000000;
            $query->whereBetween('price',[$condition1,$condition2]);
        }
        if ($request->has('province')) {
            $condition = $request->province;
            switch ($condition) {
                case 'all':
                case 'undefined':
                    break;
                default:
                    $query->whereHas('province', function ($query) use ($condition) {
                        $query->where('provinces.slug', $condition);
                    });
                    break;
            }
        }
        if ($request->has('district') && $request->district != 'all') {
            $condition = $request->district;
            switch ($condition) {
                case 'all':
                case 'undefined':
                    break;
                default:
                    $query->whereHas('district', function ($query) use ($condition) {
                        $query->where('districts.slug', $condition);
                    });
                    break;
            }
        }
        if ($request->has('fuel_type')) {
            $condition = $request->fuel_type;
            switch ($condition) {
                case '1':
                case '2':
                case '3':
                    $query->whereHas('car', function ($query) use ($condition) {
                        $query->where('cars.fuel_type', $condition);
                    });
                    break;
                default:
                    # code...
                    break;
            }
        }
        if ($request->has('seat')) {
            $condition = $request->seat;
            switch ($condition) {
                case '2':
                case '3':
                case '4':
                case '5':
                case '7':
                case '9':
                    $query->whereHas('car', function ($query) use ($condition) {
                        $query->where('cars.seats', $condition);
                    });
                    break;
                default:
                    # code...
                    break;
            }
        }
        if ($request->has('delivery')) {
            $condition = $request->delivery;
            $query->where('isDelivery',$condition);
        }
        $cars = $query->paginate(8);
        $cars->appends($_GET);

        return ThumbResource::collection($cars);
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
