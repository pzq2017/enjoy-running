<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdvertPositions extends Model
{
    use SoftDeletes;

    protected $table = 'advert_positions';

    protected $fillable = ['type', 'name', 'width', 'height'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    const TYPE_PC_PLATFORM = 1;
    const TYPE_MOBILE_PLATFORM = 2;

    public function advert()
    {
        return $this->hasMany(Advert::class, 'position_id');
    }
}
