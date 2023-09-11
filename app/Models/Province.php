<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    use HasFactory;
    use UUID;
    protected $table = 'provinces';
    protected $hidden = ['type-slug','created_at','updated_at'];
    protected $fillable = ['name','slug','code','type','type-slug'];

    public function districts() :HasMany
    {
        return $this->hasMany(District::class);
    }
}
