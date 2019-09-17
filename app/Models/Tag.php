<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $table = 'tags';

    protected $fillable = ['name', 'icon_path', 'sort'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function scopePublish($query)
    {
        return $query->where('status', 1);
    }
}
