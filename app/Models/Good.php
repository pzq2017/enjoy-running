<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Good extends Model
{
    use SoftDeletes;

    public function category()
    {
        return $this->belongsTo(GoodsCategory::class, 'category_id');
    }

    public function sizes()
    {
        return $this->hasMany(GoodSize::class, 'goods_id');
    }

    public function colors()
    {
        return $this->hasMany(GoodColor::class, 'goods_id');
    }

    public function albums()
    {
        return $this->hasMany(GoodAlbum::class, 'goods_id');
    }
}
