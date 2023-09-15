<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use UUID;
    use HasFactory;
    protected $fillable = ['parent_id','content','post_id','user_id'];
    protected $table = 'comments';
    public function car() : BelongsTo 
    {
        return $this->belongsTo(Owner::class,'post_id');    
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function children() : HasMany 
    {
        return $this->hasMany(Comment::class,'parent_id');    
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class,'id');
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class,'likes','post_id');
    }
}
