<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2018/11/27
 * Time: 17:46
 */

namespace App\Services;

use App\Models\Captcha;
use App\Models\Member;
use Carbon\Carbon;

class MemberService
{
    public static function isValidMobile($mobile)
    {
        return preg_match("/^1[34578]\d{9}$/", $mobile);
    }

    public static function isValidSmsCode($code)
    {
        return preg_match("/^[0-9]{6}$/", $code);
    }

    public static function isCorrectCaptcha($mobile, $code, $type)
    {
        $captcha = Captcha::check_sms_captcha($mobile, $code, $type);
        if (is_null($captcha)) {
            return 'no_exist';
        } else {
            $current_time = Carbon::now()->getTimestamp();
            $send_time = Carbon::parse($captcha->created_at)->timestamp;
            if (($current_time - $send_time) / 60 > Captcha::TIMEOUT_MINUTE) {
                return 'timeout';
            }
        }
        return '';
    }

    public static function isRegistered($account)
    {
        if (Member::isExistAccount($account)) {
            return true;
        }
        return false;
    }
}
