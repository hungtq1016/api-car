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
    protected $fillable = ['name','slug','seats','electric','gear','brand_id','version_id','model_id'];

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }
    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class);
    }
    public function version(): BelongsTo
    {
        return $this->belongsTo(Version::class);
    }

    public function images():BelongsToMany
    {
        return $this->belongsToMany(Image::class,'car_image','car_id');
    }
}
