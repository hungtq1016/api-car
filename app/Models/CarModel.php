<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarModel extends Model
{
    use HasFactory;
    use UUID;
    protected $table ='models';
    
    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
