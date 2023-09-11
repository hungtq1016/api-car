<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ward extends Model
{
    use HasFactory;
    use UUID;
    protected $table ='wards';
    protected $hidden = ['type-slug','created_at','updated_at','district_id'];
    protected $fillable = ['name','slug','code','district_id','type','type-slug'];

    public function district() :BelongsTo
    {
        return $this->belongsTo(District::class);
    }
}
