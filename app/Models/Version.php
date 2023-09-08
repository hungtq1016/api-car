<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Version extends Model
{
    use HasFactory;
    use UUID;

    protected $table ='versions';
    protected $hidden = ['model_id'];
    protected $fillable = ['year','model_id'];

    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }
    public function cars():HasMany
    {
        return $this->hasMany(Car::class);
    }
   
}
