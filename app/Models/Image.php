<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Image extends Model
{
    use HasFactory;
    use UUID;

    public function brands(): HasMany
    {
        return $this->hasMany(Brand::class);
    }
    // public function cars(): HasMany
    // {
    //     return $this->hasMany(Car::class);
    // }
}
