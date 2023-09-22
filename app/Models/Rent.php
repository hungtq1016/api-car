<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;
    use UUID;

    protected $table ='owner_guest';
    protected $fillable = ['owner_id','user_id','star'];
}
