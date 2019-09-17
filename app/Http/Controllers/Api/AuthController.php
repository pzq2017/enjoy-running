<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2019/9/7
 * Time: 10:28
 */

namespace App\Http\Controllers\Api;

use App\Models\Captcha;
use App\Models\Member;
use App\Services\MemberService;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends BaseController
{
    public function smsCode(Request $request)
    {
        $smsType = intval($request->smsType);
        if (!Captcha::isValidSmsCodeType($smsType)) {
            return $this->responseErrorWithMessage('无效的请求参数');
        }

        $mobile = $request->mobile;
        if (!MemberService::isValidMobile($mobile)) {
            return $this->responseErrorWithMessage('请输入有效的手机号');
        }

        //密码注册新用户需检测手机号是否已注册
        if ($smsType == Captcha::TYPE_PASSWORD_REGISTER) {
            if (MemberService::isRegistered($mobile)) {
                return $this->responseErrorWithMessage('您输入的手机号已注册为我们APP会员，请登录.');
            }
        } elseif ($smsType == Captcha::TYPE_FORGET_PASSWORD) {
            //忘记密码验证手机号是否存在
            if (!MemberService::isRegistered($mobile)) {
                return $this->responseErrorWithMessage('手机号不存在');
            }
        }

        $smsCode = Captcha::makeRandCode(6);
        if (empty($smsCode)) {
            return $this->responseErrorWithMessage('验证码获取失败');
        }

        $captcha = Captcha::create([
            'mobile' => $mobile,
            'code' => $smsCode,
            'ip' => $request->getClientIp(),
            'type' => $smsType
        ]);

        if ($captcha && $captcha->id > 0) {
            $sms = new SmsService();
            $res = $sms->smsSingleSend($mobile, null, config('sms.template_id.sms_code')[$smsType], [$smsCode, Captcha::TIMEOUT_MINUTE]);
            if ($res) {
                return $this->responseSuccess();
            } else {
                return $this->responseErrorWithMessage('验证码发送失败');
            }
        }

        return $this->responseErrorWithMessage('验证码获取失败');
    }

    public function register(Request $request)
    {
        $smsType = intval($request->smsType);       //1.密码注册; 2.手机号验证码注册
        $mobile = $request->mobile;
        $smsCode = $request->smsCode;
        $password = $request->password;

        if (!MemberService::isValidMobile($mobile)) {
            return $this->responseErrorWithMessage("请输入有效的手机号");
        }

        if (!MemberService::isValidSmsCode($smsCode)) {
            return $this->responseErrorWithMessage("验证码格式错误");
        }

        $res = MemberService::isCorrectCaptcha($mobile, $smsCode, $smsType);
        if ($res == 'no_exist') {
            return $this->responseErrorWithMessage("验证码输入不正确");
        } elseif ($res == 'timeout') {
            return $this->responseErrorWithMessage("验证码已超时，请重新发送.");
        }

        //更新验证码已被使用状态
        $captcha = new Captcha();
        $captcha->setCaptchaUsed($mobile, $smsCode, $smsType);

        //使用密码注册时检测注册账号是否已注册
        $isRegistered = MemberService::isRegistered($mobile);
        if ($smsType == Captcha::TYPE_PASSWORD_REGISTER && $isRegistered) {
            return $this->responseErrorWithMessage('您输入的手机号已注册为我们APP会员，请登录.');
        }

        DB::beginTransaction();
        try {
            $start_reg = true;
            if ($smsType == Captcha::TYPE_MOBILE_REGISTER) {
                if (!$isRegistered) {
                    //手机验证码注册设置默认密码为手机号,后续用户自己更改密码
                    $password = $mobile;
                } else {
                    //已注册直接登录
                    $start_reg = false;
                }
            }

            $token = null;
            if ($start_reg) {
                $member = new Member();
                $member->loginAccount = $mobile;
                $member->loginPwd = Hash::make($password);
                $member->mobile = $mobile;
                $member->status = Member::STATUS_ACTIVATED;
                $member->save();

                //注册完成后自动登录
                $token = auth()->attempt([
                    'loginAccount' => $mobile,
                    'password' => $password
                ]);

                DB::commit();
            } else {
                $member = Member::where('loginAccount', $mobile)->first();
                if ($member->status != Member::STATUS_ACTIVATED) {
                    return $this->responseErrorWithMessage("您的账号信息未激活");
                }

                $token = auth()->login($member);
            }

            if ($token) {
                return $this->responseSuccessWithData([
                    'uid' => $member->id,
                    'token' => $token,
                    'expire_at' => Carbon::createFromTimestamp(auth()->payload()->get('exp'))->toDateTimeString()
                ]);
            } else {
                if ($smsType == Captcha::TYPE_MOBILE_REGISTER) {
                    return $this->responseErrorWithMessage("登录失败");
                } elseif ($smsType == Captcha::TYPE_PASSWORD_REGISTER) {
                    return $this->responseErrorWithMessage("账号信息已注册成功，请去登录.");
                }
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            DB::rollBack();
        }

    }

    public function login(Request $request)
    {
        $token = auth()->attempt([
            'loginAccount' => $request->account,
            'password' => $request->password
        ]);

        if ($token) {
            $member = auth()->user();
            return $this->responseSuccessWithData([
                'uid' => $member->id,
                'token' => $token,
                'expire_at' => Carbon::createFromTimestamp(auth()->payload()->get('exp'))->toDateTimeString()
            ]);
        } else {
            return $this->responseErrorWithMessage("账号或密码错误");
        }
    }

    public function findPassword(Request $request)
    {
        $mobile = $request->mobile;
        $smsType = intval($request->smsType);
        $smsCode = $request->smsCode;
        $password = $request->password;
        $passwordConfirm = $request->passwordConfirm;

        if (!MemberService::isValidMobile($mobile)) {
            return $this->responseErrorWithMessage("请输入有效的手机号");
        }

        if (!MemberService::isRegistered($mobile)) {
            return $this->responseErrorWithMessage('手机号不存在');
        }

        if (!MemberService::isValidSmsCode($smsCode)) {
            return $this->responseErrorWithMessage("验证码格式错误");
        }

        $res = MemberService::isCorrectCaptcha($mobile, $smsCode, $smsType);
        if ($res == 'no_exist') {
            return $this->responseErrorWithMessage("验证码输入不正确");
        } elseif ($res == 'timeout') {
            return $this->responseErrorWithMessage("验证码已超时，请重新发送.");
        }

        //更新验证码已被使用状态
        $captcha = new Captcha();
        $captcha->setCaptchaUsed($mobile, $smsCode, $smsType);

        if ($password != $passwordConfirm) {
            return $this->responseErrorWithMessage("登录密码和确认密码输入不一致");
        }

        //重置密码
        Member::where('loginAccount', $mobile)->update([
            'loginPwd' => Hash::make($password)
        ]);

        return $this->responseSuccess();
    }
}
