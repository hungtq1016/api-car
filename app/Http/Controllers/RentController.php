<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteResource;
use App\Http\Resources\RentResource;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Http\Request;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $rent = Rent::where('user_id',$request->user_id)->orderBy('status','DESC')->get();
            return response()->json([
                'status_code'=>201,
                'error'=>false,
                'message'=>'Đặt Thành Công!',
                'data'=> RentResource::collection($rent)
            ],201);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra thử lại sao ít phút!',
                'error' => true,
                'throw'=>$th
            ],500);
        }
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
        try {
            $isPending = Rent::where([
                ['user_id',$request->user_id],
                ['status',0]
            ])->first();
            if ($isPending) {
                return response()->json([
                    'status_code'=>202,
                    'error'=>true,
                    'message'=>'Bạn đã đặt xe rồi.',
                ],202);
            }
            $rent = Rent::create([
                'user_id'=>$request->user_id,
                'owner_id'=>$request->owner_id,
                'address'=>$request->address,
                'start_day'=>$request->start_day,
                'end_day'=>$request->end_day,
                'total'=>$request->total,
                'star'=>5
            ]);
    
            return response()->json([
                'status_code'=>201,
                'error'=>false,
                'message'=>'Đặt Thành Công!',
                'data'=>$rent
            ],201);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra thử lại sao ít phút!',
                'error' => true,
                'throw'=>$th
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rent $rent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rent $rent)
    {
        //
    }
}
