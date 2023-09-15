<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'user' => $this->user,
            'left' => $this->left,
            'right' => $this->right,
            'like_count'=>$this->likes->count(),
            'parent_id' => $this->parent_id,
            'created_at' => $this->created_at,
            'children'=>$this->parent_id == null ? []:Self::collection($this->children),
            'hasChild'=>$this->children()->count() > 0 ? true:false,
        ];
    }
}
