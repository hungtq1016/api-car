<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Feature extends Model
{
    use HasFactory;
    use UUID;
    protected $table = 'features';
    protected $fillable = ['name','slug'];
    protected $hidden = ['pivot','id','created_at','updated_at'];

    public function cars():BelongsToMany
    {
        return $this->belongsToMany(Owner::class,'feature_car','feature_id');
    }

    public function image() : BelongsTo 
    {
        return $this->belongsTo(Image::class);    
    }
}
