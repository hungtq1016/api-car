<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use UUID;
    use HasFactory;
    protected $fillable = ['parent_id','content','post_id','user_id'];

}
