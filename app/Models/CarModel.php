<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    use HasFactory;
    use UUID;
    protected $table ='models';
    protected $hidden = ['brand_id'];
    protected $fillable = ['name','slug','brand_id'];

    public function versions(): HasMany
    {
        return $this->hasMany(Version::class,'model_id');
    }
    public function cars():HasMany
    {
        return $this->hasMany(Car::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
}
