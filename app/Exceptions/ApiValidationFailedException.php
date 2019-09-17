<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2019/9/7
 * Time: 11:11
 */

use Illuminate\Contracts\Validation\Validator;

class ApiValidationFailedException extends Exception
{
    private $validator;

    public function __construct(Validator $validator)
    {
        $this->validator = $validator;
    }

    public function response()
    {
        return response()->json([
            'status' => 'error',
            'errCode' => '0002',
            'errMsg' => $this->validator->errors()->getMessages(),
        ], 200);
    }
}