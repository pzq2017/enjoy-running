<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdvertRequest extends FormRequest
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
            'position_id' => 'required',
            'name' => 'required',
            'image_path' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ];
    }

    public function messages()
    {
        return [
            'position_id.required' => '请选择广告位置',
            'name.required' => '广告名称不能为空',
            'image_path.required' => '请上传广告图片',
            'start_date.required' => '广告开始日期不能为空',
            'start_date.date' => '广告开始日期不合法',
            'end_date.required' => '广告结束日期不能为空',
            'end_date.date' => '广告结束日期不合法',
        ];
    }
}
