<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Brand extends Model
{
    use HasFactory;
    use UUID;
    protected $table ='brands';
    protected $fillable = ['name','slug','image_id','created_at','updated_at'];
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function cars():HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function models(): HasMany
    {
        return $this->hasMany(CarModel::class);
    }
    public function versions(): HasManyThrough
    {
        return $this->hasManyThrough(Version::class, CarModel::class);
    }
}
