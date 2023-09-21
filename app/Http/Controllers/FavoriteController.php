<?php

namespace App\Http\Controllers;

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
        $like = '';
        if ($request->type=='car') {
            $owner = Owner::where('id',$request->post_id)->first();
            $like =  $owner->likes()->where('user_id',$request->user_id)->get();
        }
        if ($request->type=='comment') {
            $comment = Comment::where('id',$request->post_id)->first();
            $like = $comment->likes()->where('user_id',$request->user_id)->get();
        }
        return response()->json([
            'data'=>count($like) >0 ? true: false
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
