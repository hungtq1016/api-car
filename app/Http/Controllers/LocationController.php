<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $scope = $request->scope;
        $provinces = [];
        switch ($scope) {
            case 'thanh-pho-trung-uong';
            case 'tinh':
                $provinces = Province::where('type-slug', $scope)->with(['districts' => function ($query)  {
                    $query->orderBy('code', 'ASC');
                }])->get();
                break;

            case '2';
            case 'districts':
                $provinces = Province::with('districts')->get();
                break;

            case 'huyen';
            case 'thanh-pho';
            case 'thi-xa';
            case 'quan':
                $provinces = Province::with(['districts' => function ($query) use ($scope) {
                    $query->where('type-slug', $scope);
                }])->withCount(['districts' => function ($query) use ($scope) {
                    $query->where('type-slug', $scope);
                }])->orderBy('districts_count', 'DESC')->get();
                break;
            case '3';
            case 'wards':
                $provinces = Province::with(
                    ['districts' => function ($query) {
                        $query->with('wards');
                    }]
                )->get();
                break;
            case 'thi-tran';
            case 'phuong';
            case 'xa':
                $provinces = Province::with(
                    ['districts' => function ($query) use ($scope) {
                        $query->with(['wards' => function ($query) use ($scope) {
                            $query->where('type-slug', $scope);
                        }]);
                    }]
                )->get();
                break;
            default:
                $provinces = Province::all();
                break;
        }
        return response()->json([
            'status_code' => 200,
            'error' => false,
            'message' => 'Thành công',
            'data' => $provinces,
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
        // $provinces = $request->provinces;
        // $test=$provinces[0];
        // foreach ($provinces as $province ) {
        //     $pro = Province::create([
        //         'name'=>$province['name'],
        //         'slug'=>Str::slug($province['name'],'-'),
        //         'code'=>$province['code'],
        //         'type'=>$province['division_type'],
        //         'type-slug'=>Str::slug($province['division_type'],'-'),
        //     ]);


        //     $districts = $province['districts'];
        //     foreach ($districts as $district) {
        //         $dis = District::create([
        //             'name'=>$district['name'],
        //             'slug'=>Str::slug($district['name'],'-'),
        //             'code'=>$district['code'],
        //             'type'=>$district['division_type'],
        //             'type-slug'=>Str::slug($district['division_type'],'-'),
        //             'province_id'=>$pro->id,
        //         ]);

        //         $wards = $district['wards'];
        //         foreach ($wards as $ward) {
        //             $war = Ward::create([
        //                 'name'=>$ward['name'],
        //                 'slug'=>Str::slug($ward['name'],'-'),
        //                 'code'=>$ward['code'],
        //                 'type'=>$ward['division_type'],
        //                 'type-slug'=>Str::slug($ward['division_type'],'-'),
        //                 'district_id'=>$dis->id,
        //             ]);
        //             }
        //     }

        // }

        // return response()->json([
        //     'status_code' => 200,
        //     'error' => false,
        //     'message' => $provinces,
        // ], 200);

        return response()->json([
            'status_code' => 503,
            'error' => true,
            'message' => 'Đang bảo trì',
        ], 503);
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
