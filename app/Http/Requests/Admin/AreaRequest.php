<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AreaRequest extends FormRequest
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
            'first_letter' => 'required|regex:/[A-Z]/|max:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '地区名称不能为空',
            'first_letter.required' => '地区名称首字母不能为空',
            'first_letter.regex' => '首字母必须是大写字幕',
            'first_letter.max' => '首字母只能填写1个',
        ];
    }
}
