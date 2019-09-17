<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            'image_path' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '标签名称不能为空',
            'image_path.required' => '请上传标签图标',
        ];
    }
}
