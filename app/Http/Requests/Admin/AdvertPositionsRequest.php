<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdvertPositionsRequest extends FormRequest
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
            'width' => 'required|integer|min:0',
            'height' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '广告位置名称不能为空',
            'width.required' => '请输入当前位置的建议宽度',
            'width.integer' => '宽度输入不合法',
            'width.min' => '宽度输入不合法',
            'height.required' => '请输入当前位置的建议高度',
            'height.integer' => '高度输入不合法',
            'height.min' => '高度输入不合法',
        ];
    }
}
