<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest
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
            'name' => 'required',
            'desc' => 'max:100'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请输入角色名称',
            'desc.max' => '角色描述最多不超过100个字符'
        ];
    }
}
