<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GoodsRequest extends FormRequest
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
            'category_id' => 'required',
            'name' => 'required|max:191',
            'image_path' => 'required',
            'stock' => 'required|min:0'
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => '请选择商品所属类别',
            'name.required' => '商品名称不能为空',
            'name.max' => '商品名称最长不能超过191个字符',
            'image_path.required' => '请上传商品图片',
            'original_price.required' => '商品原价不能为空',
            'original_price.min' => '商品原价不能小于0',
            'price.required' => '商品现价不能为空',
            'price.min' => '商品现价不能小于0',
            'mileage_coin.required' => '里程币不能为空',
            'mileage_coin.min' => '里程币不能小于0',
            'gold_coin.required' => '金币不能为空',
            'gold_coin.min' => '金币不能小于0',
            'stock.required' => '库存不能为空',
            'stock.min' => '库存不能小于0',
        ];
    }

    public function withValidator($validator)
    {
        $validator->sometimes('original_price', 'required|min:0', function ($input) {
            if ($input->type == 1) {
                return true;
            }
        });

        $validator->sometimes('price', 'required|min:0', function ($input) {
            if ($input->type == 1) {
                return true;
            }
        });

        $validator->sometimes('mileage_coin', 'required|min:0', function ($input) {
            if (($input->type == 2 || $input->type == 3)  && $input->pay_method == 1) {
                return true;
            }
        });

        $validator->sometimes('gold_coin', 'required|min:0', function ($input) {
            if (($input->type == 2 || $input->type == 3)  && $input->pay_method == 2) {
                return true;
            }
        });
    }
}
