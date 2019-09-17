<?php

namespace App\Http\Requests\Admin;

use App\Models\Member;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'nickname'     => 'required',
        ];
    }

    public function messages()
    {
        return [
            'loginAccount.required' => '登录账号不能为空',
            'loginAccount.regex' => '登录账号需要是有效的手机号',
            'loginAccount.unique' => '登录账号已存在.',
            'loginPwd.required' => '登录密码不能为空.',
            'loginPwd.between' => '登录密码必须6到12位.',
            'nickname.required' => '昵称不能为空',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('loginAccount', 'required|regex:/^1[34578]\d{9}$/|unique:member,loginAccount', function ($input) {
            if (!isset($input->id)) {
                return true;
            } else {
                $exist = Member::where('id', '<>', $input->id)
                    ->where('loginAccount', $input->loginAccount)
                    ->count();
                if ($exist) {
                    return true;
                }
            }
        });
        $validator->sometimes('loginPwd', 'required|between:6,12', function ($input) {
            if (!isset($input->id)) {
                return true;
            }
        });
        $validator->sometimes('loginPwd', 'between:6,12', function ($input) {
            if (isset($input->id) && !empty($input->loginPwd)) {
                return true;
            }
        });
    }
}
