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
    
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class,'model_id');
    }
}
