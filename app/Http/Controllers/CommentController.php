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
    public function index(Request $request)
    {
        try {
            if ($request->has('parent_id')) {
                $comments = Comment::where([
                    ['post_id',$request->post_id],
                    ['left','>',$request->left],
                    ['right','<=',$request->right],
                ])->orderBy('left','ASC')->get();
                return response()->json([
                    'metadata'=> $comments
                ]);
            }else{
                $comments = Comment::where([
                    ['post_id',$request->post_id],
                    ['parent_id',null]
                ])->orderBy('left','ASC')->get();
                return response()->json([
                    'metadata'=> $comments
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra thử lại sao ít phút!',
                'error' => $th,
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
            $parentId = $request->has('parent_id') ?  $request->parent_id: null ;
            $comment = Comment::create([
                'parent_id' => $parentId,
                'post_id' => $request->post_id,
                'user_id' => $request->user_id,
                'content' => $request->content,
            ]);
            $right = 1; 
            if ($parentId) {
                $parent = Comment::findOrFail($parentId);
                if (!$parent) {
                    return response()->json([
                        'status_code' => 500,
                        'message' => 'Có lỗi xảy ra thử lại sao ít phút!'
                    ],500);
                }  
                $right = $parent->right;
                Comment::where([
                    ['post_id','=',$request->post_id],
                    ['right','>=',$right]
                ])->increment('right', 2);
                Comment::where([
                    ['post_id','=',$request->post_id],
                    ['left','>',$right]
                ])->increment('left', 2);
      
            }else{
                $maxRight = Comment::where('post_id',$request->post_id)->orderBy('right', 'DESC')->first();
                if ($maxRight) {
                    $right = $maxRight->right+1;
                }
            }
           
            Comment::where('id', $comment->id)->update(['left' => $right,'right'=>$right+1]);
            $save = Comment::where('id', $comment->id)->get();
            return response()->json([
                'message'=>$save
            ],201);
        } catch (\Throwable $th) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Có lỗi xảy ra thử lại sao ít phút!',
                'error' => $th,
            ],500);
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
