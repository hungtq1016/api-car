<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Rent extends Model
{
    use HasFactory;

    protected $table ='owner_guest';
    protected $fillable = ['owner_id','user_id','star','start_day','end_day','address','total'];


    public function car(): HasOneThrough
    {
        return $this->hasOneThrough(
            Car::class,       // model trying to get
            Owner::class,      // model have an _id to
            'id',                 // WHERE `car`.`id` = `owner`.`car_id`
            'id',                 // `brand`.`id`
            'owner_id',        // local column relation to our through class
            'car_id'          // `car`.`brand_id`
        );
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo( Owner::class);
    }
}
