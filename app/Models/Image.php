<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    use HasFactory;
    use UUID;
    protected $fillable = ['src','local_src'];
    protected $hidden = ['pivot','id','created_at','updated_at'];
    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }
    public function cars():BelongsToMany
    {
        return $this->belongsToMany(Image::class,'car_image','image_id');
    }
}
