<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Good extends Model
{
    use SoftDeletes;

    //商品类型
    const TYPE_VIRTUAL = 1;     //虚拟商品(装扮)
    const TYPE_REAL = 2;        //实体商品(装备)
}
