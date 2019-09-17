<?php

namespace App\Http\Requests\Admin;

use App\Models\Staffs;
use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'loginName.required' => '登录账号不能为空.',
            'loginName.unique' => '登录账号已存在.',
            'password.required' => '登录密码不能为空.',
            'password.between' => '登录密码必须6到12位.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('loginName', 'unique:staffs,loginName', function ($input) {
            if (!isset($input->id)) {
                return true;
            } else {
                $exist = Staffs::where('id', '<>', $input->id)
                                ->where('loginName', $input->loginName)
                                ->count();
                if ($exist) {
                    return true;
                }
            }
        });
        $validator->sometimes('password', 'required|between:6,12', function ($input) {
            if (!isset($input->id)) {
                return true;
            }
        });
        $validator->sometimes('password', 'between:6,12', function ($input) {
            if (isset($input->id) && !empty($input->password)) {
                return true;
            }
        });
    }
}
