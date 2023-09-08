<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;
    use UUID;

    protected $table ='owners';
    protected $fillable = ['province','district','phone','electric','description','gear'];
}
