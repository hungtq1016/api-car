<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Car extends Model
{
    use HasFactory;
    use UUID;
    protected $table ='cars';

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(CarClass::class, 'car_class');
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(Model::class);
    }
}
