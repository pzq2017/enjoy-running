<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Captcha extends Model
{
    protected $table = 'captcha';

    protected $fillable = ['mobile', 'code', 'ip', 'type'];

    protected $dates = ['created_at', 'updated_at'];

    const TIMEOUT_MINUTE = 2;               //验证码有效期2分钟

    /**
     * 验证码类型
     */
    const TYPE_PASSWORD_REGISTER = 1;       //密码注册验证码
    const TYPE_MOBILE_REGISTER = 2;         //手机号注册验证码
    const TYPE_FORGET_PASSWORD = 3;         //忘记密码验证码

    public static function makeRandCode($length)
    {
        $str = '0123456789';
        $sLen = strlen($str) - 1;
        $code = '';
        while ($length--) {
            $pos = mt_rand(0, $sLen);
            $code .= $str[$pos];
        }
        return $code;
    }

    public static function isValidSmsCodeType($type)
    {
        return in_array($type, [
            self::TYPE_PASSWORD_REGISTER,
            self::TYPE_MOBILE_REGISTER,
            self::TYPE_FORGET_PASSWORD,
        ]);
    }

    public static function check_sms_captcha($mobile, $code, $type)
    {
        return self::where([
            ['mobile', '=', $mobile],
            ['code', '=', $code],
            ['type', '=', $type],
            ['status', '=', 0]
        ])->latest()->first();
    }

    public function setCaptchaUsed($mobile, $code, $type)
    {
        self::where([
            ['mobile', '=', $mobile],
            ['code', '=', $code],
            ['type', '=', $type],
            ['status', '=', 0]
        ])->update(['status' => 1]);
    }
}
