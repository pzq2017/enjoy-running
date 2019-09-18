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
}
