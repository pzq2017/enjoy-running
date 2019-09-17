<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Member extends Authenticatable implements JWTSubject
{
    use SoftDeletes;

    protected $table = 'member';

    protected $hidden = ['loginPwd'];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * 会员账号状态
     */
    const STATUS_DISABLED = 0;      //账号禁止
    const STATUS_ACTIVATED = 1;        //账号激活

    public function getSexAttribute($value)
    {
        if ($value == 1) {
            return '男';
        } elseif ($value == 2) {
            return '女';
        }
        return '未知';
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @return mixed
     */
    public function getAuthPassword()
    {
        return $this->loginPwd;
    }

    public static function isExistAccount($account)
    {
        return self::where('loginAccount', $account)->count() > 0 ? true : false;
    }
}
