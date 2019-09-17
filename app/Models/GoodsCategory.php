<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsCategory extends Model
{
    use SoftDeletes;

    protected $table = 'goods_category';

    protected $fillable = ['name', 'status'];

    public function goods()
    {
        return $this->hasMany(Good::class, 'category_id');
    }
}
