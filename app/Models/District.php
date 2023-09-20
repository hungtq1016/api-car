<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    use HasFactory;
    use UUID;
    protected $table ='districts';
    protected $hidden = ['type-slug','created_at','updated_at','province_id'];
    protected $fillable = ['name','slug','code','province_id','type','type-slug'];

    public function province() :BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class);
    }

    public function cars() :HasMany
    {
        return $this->hasMany(Owner::class);
    }
}
