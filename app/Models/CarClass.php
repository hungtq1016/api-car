<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class CarClass extends Model
{
    use HasFactory;
    use UUID;
    // protected $table ='class';

    // public function cars(): BelongsToMany
    // {
    //     return $this->belongsToMany(Car::class, 'car_class');
    // }
}
