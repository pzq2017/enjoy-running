<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdPwdRequest extends FormRequest
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
            'oldPwd' => 'required',
            'newPwd' => 'required|min:6|confirmed',
            'newPwd_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'oldPwd.required' => '请输入原始密码',
            'newPwd.required' => '请输入新密码',
            'newPwd.min' => '新密码最小需要6位',
            'newPwd.confirmed' => '确认密码输入不一致',
            'newPwd_confirmation.required' => '请输入确认密码',
        ];
    }
}
