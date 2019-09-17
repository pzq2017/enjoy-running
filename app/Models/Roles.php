<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model
{
    use SoftDeletes;

    protected $table = 'roles';

    protected $fillable = ['name', 'desc', 'privileges'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
}
