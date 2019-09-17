<?php
/**
 * Created by PhpStorm.
 * User: pan
 * Date: 2019/9/7
 * Time: 10:36
 */

namespace App\Http\Controllers\Api;

use ApiValidationFailedException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BaseController extends Controller
{
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';

    /**
     * @param Request $request
     * @param array $rules
     * @param array $messages
     * @throws ApiValidationFailedException
     */
    public function validateWithException(Request $request, array $rules, array $messages = [])
    {
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            throw new ApiValidationFailedException($validator);
        }
    }

    /**
     * @param $errMsg
     * @param string $errCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseErrorWithMessage($errMsg, $errCode="")
    {
        return response()->json([
            'status' => self::STATUS_ERROR,
            'errCode' => $errCode ?  $errCode : '0002',
            'errMsg'=> $errMsg,
        ], 200);
    }

    public function responseSuccess()
    {
        return response()->json([
            'status' => self::STATUS_SUCCESS,
        ], 200);
    }

    public function responseSuccessWithData($data = [])
    {
        return response()->json([
            'status' => self::STATUS_SUCCESS,
            'result' => $data
        ]);
    }
}