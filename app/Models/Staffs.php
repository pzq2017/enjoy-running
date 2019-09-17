<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staffs extends Authenticatable
{
    use SoftDeletes;

    protected $table = 'staffs';

    protected $fillable = ['loginName', 'password', 'secretKey', 'staffName', 'staffPhone', 'staffEmail', 'staffPhoto', 'staffRoleId', 'status'];

    protected $hidden = ['password', 'secretKey'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at', 'lastTime'];

    const SUPER_USER = -1;		//超管

    const STATUS_ACTIVE = 1;	//账号激活

    const STATUS_DISABLED = 0;	//账号禁止

    public function role()
    {
    	return $this->belongsTo(Roles::class, 'staffRoleId');
    }
}
