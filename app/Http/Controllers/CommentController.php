<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
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

        try {
            $parent = $request->has('parent_id') ?  $request->parent_id: null ;
            $comment = Comment::create([
                'parent_id' => $parent,
                'post_id' => $request->post_id,
                'user_id' => $request->user_id,
                'content' => $request->content,
            ]);
            if ($parent) {
                # code...
            }else{
                $right = 1;
                $maxRight = Comment::where('post_id', $request->post_id)->orderBy('right', 'DESC')->first();
                if ($maxRight) {
                    $rightValue = $maxRight->right;
    
                    $right = $rightValue +1;
                }
                Comment::where('id', $comment->id)->update(['left' => $right,'right'=>$right+1]);
            }
            return response()->json([
                'metadata'=>$comment
            ],201);

        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra thử lại sao ít phút!',
                'error' => $th,
            ]);
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
