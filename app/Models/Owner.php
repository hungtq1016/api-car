<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Owner extends Model
{
    use HasFactory;
    use UUID;

    protected $table ='owners';
    protected $fillable = ['province_id','district_id','desc','price','car_id','user_id'];

    public function images():BelongsToMany
    {
        return $this->belongsToMany(Image::class,'owner_image','owner_id');
    }

    public function features():BelongsToMany
    {
        return $this->belongsToMany(Feature::class,'feature_car','owner_id');
    }

    public function car():BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments() : HasMany 
    {
        return $this->hasMany(Comment::class); 
    }
}
