<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'loginName' => 'required',
            'loginPwd' => 'required',
            'verifyCode' => 'required|captcha'
        ];
    }

    /**
     * 获取已定义的验证规则的错误信息
     *
     * @return array
     */
    public function messages()
    {
        return [
            'loginName.required' => '登录账号不能为空',
            'loginPwd.required' => '登录密码不能为空',
            'verifyCode.required' => '验证码不能为空',
            'verifyCode.captcha' => '验证码错误',
        ];
    }
}
