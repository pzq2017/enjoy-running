<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodAlbum extends Model
{
    use SoftDeletes;

    protected $table = 'goods_album';

    protected $fillable = ['goods_id', 'goods_color_id', 'image'];
}
