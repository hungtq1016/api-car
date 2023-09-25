<?php

namespace App\Http\Controllers;

use App\Http\Resources\FavoriteResource;
use App\Http\Resources\UsersLikeResource;
use App\Models\Comment;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
      
        try {
            $favorites = [];
            if ($request->type=='car') {
                $user = User::where('id',$request->user_id)->first();
                $favorites = $user->favorites;
            }
    
            return response()->json([
                'status_code'=>200,
                'error'=>false,
                'message'=>'Thành công',
                'data'=> FavoriteResource::collection($favorites)
            ]);
    
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
            $owner = Owner::where('id',$request->post_id)->first();
        $comment = Comment::where('id',$request->post_id)->first();
        $data = '';
        if ($request->type == 'comment') {
            if ($request->like) {
                $comment->likes()->attach($request->user_id);
            }else{
                $comment->likes()->detach($request->user_id);
            }
            $data = $comment->likes;
        }else{
            if ($request->like) {
                $owner->likes()->attach($request->user_id);
            }else{
                $owner->likes()->detach($request->user_id);
            }
            $data = $owner->likes;
        }
        return response()->json([
            'status_code'=>200,
            'data'=> UsersLikeResource::collection($data)
        ]);
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
    public function destroy(Request $request,string $id)
    {
        try {
            $user = User::where('id',$id)->first();
            $data = '';
            if ($request->type == 'comment') {
            }else{
                $user->favorites()->detach($request->post_id);
                $data = $user->favorites;
            }
            return response()->json([
                'status_code'=>200,
                'message'=>'Xóa thành công',
                'error'=>false,
                'data'=> FavoriteResource::collection($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra thử lại sao ít phút!',
                'error' => true,
                'throw'=>$th
            ],500);
        }
    }
}
