<?php

namespace App\Http\Controllers;

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
        $query = Owner::query();
        $query->where('id',$request->post_id)->first();
        if ($request->type=='car') {
            $query->likes()->where('user_id',$request->user_id)->get();
        }
        if ($request->type=='comment') {
            $query->with('comments')->get();
        }
        $like = $query;
        return response()->json([
            'data'=>$like
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
        $post = Owner::where('id',$request->post_id)->first();
        $data ='';
        if ($request->like) {
            $data = $post->likes()->detach($request->user_id);
        }else{
            $data =  $post->likes()->attach($request->user_id);
        }
        return response()->json([
            'status_code'=>!$request->like?200:201,
            'data'=>!$data
        ],!$request->like?200:201);
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
