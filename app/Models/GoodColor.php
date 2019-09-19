<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodColor extends Model
{
    use SoftDeletes;

    protected $table = 'goods_color';

    protected $fillable = ['goods_id', 'name'];
}
