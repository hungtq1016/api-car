<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;
    use UUID;

    protected $table ='rents';
    protected $fillable = ['owner_id','guest_id','address','phone','total','count_days','star_day','end_day','fees'];
}
