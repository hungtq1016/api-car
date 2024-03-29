<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Owner extends Model
{
    use HasFactory;
    use UUID;

    protected $table ='owners';
    protected $fillable = ['province_id','district_id','desc','price','car_id','user_id','isDelivery','isInstant','isMortgages','address','isIdentity','isInsurance','delivery_fee'];

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

    public function district():BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function province():BelongsTo
    {
        return $this->belongsTo(Province::class);
    }
    public function ward():BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function latestComment():HasOne
    {
        return $this->hasOne(Comment::class,'post_id')->latest('right');
    }

    public function comments() : HasMany 
    {
        return $this->hasMany(Comment::class,'post_id'); 
    }

    public function guests() : BelongsToMany 
    {
        return $this->belongsToMany(User::class,'owner_guest','owner_id');
    }

    public function likes() : BelongsToMany 
    {
        return $this->belongsToMany(User::class,'likes','post_id');
    }

    public function brand(): HasOneThrough
    {
        return $this->hasOneThrough(
            Brand::class,       // model trying to get
            Car::class,      // model have an _id to
            'id',                 // WHERE `car`.`id` = `owner`.`car_id`
            'id',                 // `brand`.`id`
            'car_id',        // local column relation to our through class
            'brand_id'          // `car`.`brand_id`
        );
    }
    
}
