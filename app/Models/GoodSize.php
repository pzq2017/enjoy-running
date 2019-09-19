<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodSize extends Model
{
    protected $table = 'goods_size';

    protected $fillable = ['goods_id', 'name'];
}
