<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advert extends Model
{
    use SoftDeletes;

    protected $table = 'advert';

    protected $fillable = ['position_id', 'name', 'image_path', 'url', 'start_date', 'end_date', 'sort'];

    protected $dates = ['publish_date', 'created_at', 'updated_at', 'deleted_at'];

    public function advert_positions()
    {
        return $this->belongsTo(AdvertPositions::class, 'position_id');
    }
}
